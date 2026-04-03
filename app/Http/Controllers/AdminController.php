<?php

namespace App\Http\Controllers;

use App\Models\StudentApplication;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 3.1.1 View Pending Applications
    public function getPendingApplications() {
        $applications = StudentApplication::where('status', 'Pending')->get();
        return response()->json($applications, 200);
    }

    // 3.1.4 Approve Application
    public function approveApplication($id) {
        $application = StudentApplication::find($id);

        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        $application->update([
            'status' => 'Approved',
            'rejection_reason' => null // Clear any previous reasons
        ]);

        return response()->json([
            'message' => 'Application successfully approved. Grantee status generated.',
            'data' => $application
        ], 200);
    }

    // 3.1.5 Reject Application (Requires a reason)
    public function rejectApplication(Request $request, $id) {
        $request->validate([
            'rejection_reason' => 'required|string'
        ]);

        $application = StudentApplication::find($id);

        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        $application->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        return response()->json([
            'message' => 'Application rejected.',
            'data' => $application
        ], 200);
    }

    // 3.2.1 Generate List of Enrolled Grantees
    public function getApprovedGrantees() {
        // Fetches all applications that have been approved
        $grantees = StudentApplication::where('status', 'Approved')->get();
        return response()->json($grantees, 200);
    }
}