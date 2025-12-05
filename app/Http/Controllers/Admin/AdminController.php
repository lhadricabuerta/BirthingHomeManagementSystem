<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\AuditLog;
use App\Models\Client;
use App\Models\Patient;
use App\Models\PatientPdfRecord;
use App\Models\User;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $selectedBranch = $request->get('branch', 'Combined');

        $branchMap = [
            'Santa Justina' => 1,
            'San Pedro'     => 2,
        ];

        $branchId = $selectedBranch !== 'Combined'
            ? ($branchMap[$selectedBranch] ?? null)
            : null;

        $today = Carbon::today();

        $totalPatientsQuery = Patient::query();
        if ($branchId) {
            $totalPatientsQuery->where('branch_id', $branchId);
        }
        $totalPatients = $totalPatientsQuery->count();

        $todaysAppointmentsQuery = Appointment::whereDate('appointment_date', $today)
            ->whereNotIn('status_id', [3, 4]);
        if ($branchId) {
            $todaysAppointmentsQuery->where('branch_id', $branchId);
        }
        $todaysAppointments = $todaysAppointmentsQuery->count();

        $cancelledAppointmentsQuery = Appointment::where('status_id', 3)
            ->whereDate('appointment_date', $today);
        if ($branchId) {
            $cancelledAppointmentsQuery->where('branch_id', $branchId);
        }
        $cancelledAppointments = $cancelledAppointmentsQuery->count();

        $missedAppointmentsQuery = Appointment::where('status_id', 5)
            ->whereDate('appointment_date', '<', $today);
        if ($branchId) {
            $missedAppointmentsQuery->where('branch_id', $branchId);
        }
        $missedAppointments = $missedAppointmentsQuery->count();

        $reportsQuery = PatientPdfRecord::whereDate('created_at', $today);
        if ($branchId) {
            $reportsQuery->whereHas('patient', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }
        $reports = $reportsQuery->count();

        $auditLogs = AuditLog::with('staff')
            ->latest()
            ->take(7)
            ->get()
            ->map(function ($log) {
                return [
                    'staff_name' => $log->staff
                        ? $log->staff->first_name . ' ' . $log->staff->last_name
                        : 'System',
                    'action'     => $log->action,
                    'date'       => $log->created_at->format('Y-m-d H:i'),
                    'details'    => $log->details,
                ];
            });

        $appointmentsQuery = Appointment::with('client')
            ->whereNotIn('status_id', [3, 4]);

        if ($branchId) {
            $appointmentsQuery->where('branch_id', $branchId);
        }

        $appointmentsData = $appointmentsQuery
            ->select('appointment_date', 'appointment_time', 'appointment_reason', 'client_id', 'branch_id')
            ->get()
            ->map(function ($appt) {
                return [
                    'date'   => $appt->appointment_date,
                    'time'   => $appt->appointment_time,
                    'reason' => $appt->appointment_reason,
                    'client' => $appt->client
                        ? $appt->client->first_name . ' ' . $appt->client->last_name
                        : 'Unknown',
                    'branch' => $appt->branch_id == 1 ? 'Santa Justina' :
                    ($appt->branch_id == 2 ? 'San Pedro' : 'Unknown'),
                ];
            });

        $cancelledTodayListQuery = Appointment::with(['client', 'branch'])
            ->where('status_id', 3)
            ->whereDate('updated_at', $today)
            ->orderBy('appointment_time');

        if ($branchId) {
            $cancelledTodayListQuery->where('branch_id', $branchId);
        }

        $cancelledTodayList = $cancelledTodayListQuery
            ->get()
            ->map(function ($appt) {
                $timeLabel = null;
                if ($appt->appointment_time) {
                    try {
                        $timeLabel = Carbon::parse($appt->appointment_time)->format('g:i A');
                    } catch (\Exception $e) {
                        $timeLabel = $appt->appointment_time;
                    }
                }

                return [
                    'time'       => $appt->appointment_time,
                    'time_label' => $timeLabel,
                    'client'     => $appt->client
                        ? trim($appt->client->first_name . ' ' . $appt->client->last_name)
                        : 'Unknown',
                    'reason'     => $appt->appointment_reason,
                    'branch'     => optional($appt->branch)->name,
                    'view_url'   => route('editAppointment', ['id' => $appt->id]),
                ];
            })
            ->values()
            ->all();

        $clientsQuery = Client::with(['prenatalVisits.visitInfo']);
        if ($branchId) {
            $clientsQuery->whereHas('patient', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $nextVisits = $clientsQuery->get()
            ->map(function ($client) {
                $prenatalVisits = $client->prenatalVisits ?? collect();
                if ($prenatalVisits->isEmpty()) {
                    return null;
                }

                $latestPrenatal  = $prenatalVisits->sortByDesc('id')->first();
                $latestVisitInfo = $latestPrenatal->visitInfo->sortByDesc('visit_number')->first();

                if ($latestPrenatal->prenatal_status_id == 2) {
                    return null;
                }

                if (! $latestVisitInfo) {
                    return null;
                }

                return [
                    'date'   => $latestVisitInfo->next_visit_date,
                    'time'   => $latestVisitInfo->next_visit_time,
                    'reason' => 'Next Prenatal Visit',
                    'client' => $client->first_name . ' ' . $client->last_name,
                    'branch' => $client->patient?->branch_id == 1 ? 'Santa Justina' :
                    ($client->patient?->branch_id == 2 ? 'San Pedro' : 'Unknown'),
                ];
            })
            ->filter();

        $appointmentsData = $appointmentsData->merge($nextVisits);

        $todayDayOfWeek = $today->dayOfWeek; 
        
        $dayNames = [0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 
                     4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'];
        $todayDayName = $dayNames[$todayDayOfWeek];

       
        $staffOnDutyQuery = Staff::with('workDays')
            ->whereHas('workDays', function ($q) use ($todayDayName) {
                $q->where('day', $todayDayName);
            });

        if ($branchId) {
            $staffOnDutyQuery->where('branch_id', $branchId);
        }

         $staffOnDuty = $staffOnDutyQuery->get()
    ->map(function ($staff) {
        return [
            'id'          => $staff->id,
            'name'        => $staff->first_name . ' ' . $staff->last_name,
            'full_name'   => $staff->first_name . ' ' . $staff->last_name,
            'position'    => $staff->user?->role ?? 'Staff',
            'role'        => $staff->user?->role ?? 'Staff',
            'avatar_path' => $staff->avatar_path 
                                ? asset($staff->avatar_path)
                                : null
        ];
    });


        return view('admin.dashboard.dashboard', compact(
            'selectedBranch',
            'totalPatients',
            'todaysAppointments',
            'cancelledAppointments',
            'missedAppointments',
            'reports',
            'auditLogs',
            'appointmentsData',
            'staffOnDuty', 
            'cancelledTodayList'
        ));
    }

    public function adminProfile()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view the profile.');
        }

        $admin = $user->admin;

        return view('admin.adminProfile.profile', compact('user', 'admin'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
        ]);

        $user  = Auth::user();
        $admin = $user->admin;

        // Update user email
        $user->email = $request->email;
        $user->save();

        // Ensure $admin exists
        if (! $admin) {
            return redirect()->back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Profile Not Found!',
                'text'  => 'Admin profile not found!',
            ]);
        }

        // Update admin profile fields
        $admin->first_name = $request->first_name;
        $admin->last_name  = $request->last_name;
        $admin->phone      = $request->phone;
        $admin->address    = $request->address;
        $admin->save();

        return redirect()->back()->with('swal', [
            'icon'  => 'success',
            'title' => 'Profile Updated!',
            'text'  => 'Your profile has been updated successfully.',
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user  = Auth::user();
        $admin = $user->admin;

        if (! $admin) {
            return back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Profile Not Found!',
                'text'  => 'Admin profile not found!',
            ]);
        }

        
        if ($admin->avatar_path && file_exists(public_path($admin->avatar_path))) {
            @unlink(public_path($admin->avatar_path));
        }

        // Save new avatar using Laravel Storage (better than manual move)
        $file     = $request->file('avatar');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        // store in "public/avatars"
        $path = $file->storeAs('avatars', $filename, 'public');

        // Update DB
        $admin->avatar_path = 'storage/' . $path;
        $admin->save();

        return back()->with('swal', [
            'icon'  => 'success',
            'title' => 'Avatar Updated!',
            'text'  => 'Your profile picture has been updated successfully.',
        ]);
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password'     => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/',
                ],
            ], [
                'new_password.regex'     => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).',
                'new_password.confirmed' => 'New password and confirm password do not match.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Invalid Password',
                'text'  => $e->validator->errors()->first('new_password'),
            ]);
        }

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('swal', [
                'icon'  => 'error',
                'title' => 'Incorrect Password',
                'text'  => 'The current password you entered is incorrect.',
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('swal', [
            'icon'  => 'success',
            'title' => 'Password Changed!',
            'text'  => 'Your password has been updated successfully.',
        ]);
    }
}