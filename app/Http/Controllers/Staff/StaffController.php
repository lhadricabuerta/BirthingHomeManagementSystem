<?php

namespace App\Http\Controllers\Staff;

use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StaffController extends BaseStaffController
{
    public function dashboard()
    {
        $user = Auth::user();

        // default selectedBranch (fallback)
        $selectedBranch = 'Combined';

        if ($user->role === 'staff' && $user->staff) {
            $branchId = $user->staff->branch_id;

            // Try get branch name from staff relation if available
            $selectedBranch = optional($user->staff->branch)->name ?? $selectedBranch;

            // total patients in this branch (has appointments in branch)
            $totalPatients = Client::whereHas('appointments', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })->count();

            // count of today's active appointments (exclude cancelled + archived)
            $todaysAppointments = Appointment::where('branch_id', $branchId)
                ->whereDate('appointment_date', now()->toDateString())
                ->whereNotIn('status_id', [3, 4])
                ->count();

            // 🔥 CANCELLED APPOINTMENTS (status_id = 3)
            $cancelledAppointments = Appointment::where('branch_id', $branchId)
                ->where('status_id', 3)
                ->count();

            $cancelledTodayList = Appointment::with(['client','branch'])
                ->where('branch_id', $branchId)
                ->whereDate('updated_at', now()->toDateString())
                ->where('status_id', 3)
                ->orderBy('appointment_time')
                ->get()
                ->map(function ($appt) {
                    $timeFormatted = null;
                    if ($appt->appointment_time) {
                        try {
                            $timeFormatted = Carbon::parse($appt->appointment_time)->format('g:i A');
                        } catch (\Exception $e) {
                            $timeFormatted = $appt->appointment_time;
                        }
                    }

                    return [
                        'time'     => $appt->appointment_time,
                        'time_label' => $timeFormatted,
                        'client'   => $appt->client ? trim($appt->client->first_name . ' ' . $appt->client->last_name) : 'Unknown',
                        'reason'   => $appt->appointment_reason,
                        'branch'   => optional($appt->branch)->name,
                        'view_url' => route('editAppointment', ['id' => $appt->id]),
                    ];
                })
                ->values()
                ->all();

            $completedVisits = Client::with(['patient', 'prenatalVisits', 'patient.deliveries'])
                ->whereHas('patient', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })
                ->get()
                ->filter(function ($client) {
                    $completed = $client->prenatalVisits
                        ->where('prenatal_status_id', 2)
                        ->sortByDesc('id');

                    if ($completed->isEmpty()) {
                        return false;
                    }

                    $latest         = $completed->first();
                    $linkedDelivery = $client->patient->deliveries
                        ->firstWhere('prenatal_visit_id', $latest->id);

                    if ($linkedDelivery && $linkedDelivery->delivery_status_id == 2) {
                        return false; // already delivered
                    }

                    return true;
                })
                ->count();

            // appointmentsData collects appointments + next visits (used for calendar)
            $appointmentsData = Appointment::with(['client', 'branch'])
                ->where('branch_id', $branchId)
                ->whereNotIn('status_id', [3, 4])
                ->select('id','appointment_date', 'appointment_time', 'appointment_reason', 'client_id', 'branch_id')
                ->get()
                ->map(function ($appt) {
                    return [
                        'id'     => $appt->id,
                        'date'   => $appt->appointment_date,
                        'time'   => $appt->appointment_date && $appt->appointment_time
                                    ? $appt->appointment_date . 'T' . $appt->appointment_time
                                    : ($appt->appointment_time ?? ''),
                        'reason' => $appt->appointment_reason,
                        'client' => $appt->client ? trim($appt->client->first_name . ' ' . $appt->client->last_name) : 'Unknown',
                        'branch' => optional($appt->branch)->name ?? 'Unknown',
                        'is_appointment' => true,
                    ];
                });

            $nextVisits = Client::with(['patient', 'prenatalVisits.visitInfo', 'patient.branch'])
                ->whereHas('patient', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })
                ->get()
                ->map(function ($client) {
                    $prenatalVisits = $client->prenatalVisits ?? collect();
                    if ($prenatalVisits->isEmpty()) {
                        return null;
                    }

                    $latestPrenatal  = $prenatalVisits->sortByDesc('id')->first();
                    $latestVisitInfo = $latestPrenatal->visitInfo->sortByDesc('visit_number')->first();

                    // skip completed prenatal (status_id = 2)
                    if ($latestPrenatal->prenatal_status_id == 2) {
                        return null;
                    }

                    if (! $latestVisitInfo) {
                        return null;
                    }

                    return [
                        'id'     => 'prenatal-' . $latestVisitInfo->id,
                        'date'   => $latestVisitInfo->next_visit_date,
                        'time'   => $latestVisitInfo->next_visit_date && $latestVisitInfo->next_visit_time
                                    ? $latestVisitInfo->next_visit_date . 'T' . $latestVisitInfo->next_visit_time
                                    : ($latestVisitInfo->next_visit_time ?? ''),
                        'reason' => 'Next Prenatal Visit',
                        'client' => trim($client->first_name . ' ' . $client->last_name),
                        'branch' => optional($client->patient->branch)->name ?? 'Unknown',
                        'is_appointment' => false,
                    ];
                })
                ->filter();

            $appointmentsData = $appointmentsData->merge($nextVisits)->values();

        } else {

            $totalPatients = Client::count();

            $todaysAppointments = Appointment::whereDate('appointment_date', now()->toDateString())
                ->whereNotIn('status_id', [3, 4])
                ->count();

            // 🔥 CANCELLED (ALL BRANCHES)
            $cancelledAppointments = Appointment::where('status_id', 3)->count();

            $cancelledTodayList = Appointment::with(['client', 'branch'])
                ->whereDate('updated_at', now()->toDateString())
                ->where('status_id', 3)
                ->orderBy('appointment_time')
                ->get()
                ->map(function ($appt) {
                    $timeFormatted = null;
                    if ($appt->appointment_time) {
                        try {
                            $timeFormatted = Carbon::parse($appt->appointment_time)->format('g:i A');
                        } catch (\Exception $e) {
                            $timeFormatted = $appt->appointment_time;
                        }
                    }

                    return [
                        'time'     => $appt->appointment_time,
                        'time_label' => $timeFormatted,
                        'client'   => $appt->client ? trim($appt->client->first_name . ' ' . $appt->client->last_name) : 'Unknown',
                        'reason'   => $appt->appointment_reason,
                        'branch'   => optional($appt->branch)->name,
                        'view_url' => route('editAppointment', ['id' => $appt->id]),
                    ];
                })
                ->values()
                ->all();

            $completedVisits = Client::with(['prenatalVisits', 'patient.deliveries'])
                ->get()
                ->filter(function ($client) {
                    $completed = $client->prenatalVisits
                        ->where('prenatal_status_id', 2)
                        ->sortByDesc('id');

                    if ($completed->isEmpty()) {
                        return false;
                    }

                    $latest         = $completed->first();
                    $linkedDelivery = $client->patient->deliveries
                        ->firstWhere('prenatal_visit_id', $latest->id);

                    if ($linkedDelivery && $linkedDelivery->delivery_status_id == 2) {
                        return false;
                    }

                    return true;
                })
                ->count();

            $appointmentsData = Appointment::with(['client', 'branch'])
                ->whereNotIn('status_id', [3, 4])
                ->select('id','appointment_date', 'appointment_time', 'appointment_reason', 'client_id', 'branch_id')
                ->get()
                ->map(function ($appt) {
                    return [
                        'id'     => $appt->id,
                        'date'   => $appt->appointment_date,
                        'time'   => $appt->appointment_date && $appt->appointment_time
                                    ? $appt->appointment_date . 'T' . $appt->appointment_time
                                    : ($appt->appointment_time ?? ''),
                        'reason' => $appt->appointment_reason,
                        'client' => $appt->client ? trim($appt->client->first_name . ' ' . $appt->client->last_name) : 'Unknown',
                        'branch' => optional($appt->branch)->name ?? null,
                        'is_appointment' => true,
                    ];
                });

            $nextVisits = Client::with(['prenatalVisits.visitInfo', 'patient', 'patient.branch'])
                ->get()
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
                        'id'     => 'prenatal-' . $latestVisitInfo->id,
                        'date'   => $latestVisitInfo->next_visit_date,
                        'time'   => $latestVisitInfo->next_visit_date && $latestVisitInfo->next_visit_time
                                    ? $latestVisitInfo->next_visit_date . 'T' . $latestVisitInfo->next_visit_time
                                    : ($latestVisitInfo->next_visit_time ?? ''),
                        'reason' => 'Next Prenatal Visit',
                        'client' => trim($client->first_name . ' ' . $client->last_name),
                        'branch' => optional($client->patient->branch)->name ?? null,
                        'is_appointment' => false,
                    ];
                })
                ->filter();

            $appointmentsData = $appointmentsData->merge($nextVisits)->values();
        }

        // Build calendar events
        $calendarEvents = $appointmentsData->map(function ($item) {
            $date = $item['date'] ?? null;
            $time = '';

            if (!empty($item['time'])) {
                $parts = explode('T', $item['time']);
                $time = $parts[1] ?? $item['time'];
            }

            $title = trim(($item['client'] ?? '') . ($item['reason'] ? ' — ' . $item['reason'] : ''));

            $viewUrl = '';
            if (!empty($item['id'])) {
                if (is_numeric($item['id'])) {
                    $viewUrl = route('editAppointment', ['id' => $item['id']]);
                } else {
                    $viewUrl = url('/patients');
                }
            }

            return [
                'date'     => $date,
                'title'    => $title,
                'time'     => $time,
                'view_url' => $viewUrl,
                'branch'   => $item['branch'] ?? null,
            ];
        })->filter(function ($e) {
            return !empty($e['date']);
        })->values()->all();

        // Today's appointments
        $today = now()->toDateString();
        $todaysAppointmentsList = collect($appointmentsData)->filter(function ($item) use ($today) {
            return isset($item['date']) && $item['date'] === $today;
        })->map(function ($item) {
            return [
                'time'       => $item['time'] ?? '',
                'client_name'=> $item['client'] ?? 'Unknown',
                'reason'     => $item['reason'] ?? '',
                'view_url'   => !empty($item['id']) && is_numeric($item['id']) ? route('editAppointment', ['id' => $item['id']]) : '#',
                'checkin_url'=> null,
                'branch'     => $item['branch'] ?? null,
            ];
        })->values()->all();

        // refresh URL (unused)
        $appointmentsRefreshUrl = '';

        return view('staff.dashboard.dashboard', compact(
            'totalPatients',
            'todaysAppointments',
            'cancelledAppointments',
            'appointmentsData',
            'completedVisits',
            'calendarEvents',
            'todaysAppointmentsList',
            'appointmentsRefreshUrl',
            'selectedBranch',
            'cancelledTodayList'
        ));
    }
}
