<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emergency;

class EmergencyController extends Controller
{
    public function index()
    {
      
        $emergencies = Emergency::with('branch')
            ->latest()
            ->get();

        if ($emergencies->isEmpty()) {
            return ''; 
        }

        return view('partials.emergencyModal', compact('emergencies'));
    }

    public function destroy($id)
    {
        $emergency = Emergency::find($id);

        if (! $emergency) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Emergency not found',
            ], 404);
        }

        $emergency->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Emergency acknowledged and removed',
        ]);
    }
}
