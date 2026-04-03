<?php

namespace App\Http\Controllers;

use App\Models\StudentApplication;
use Illuminate\Http\Request;

class StudentApplicationController extends Controller
{
    // GET: Fetch all applications
    public function index() {
        return StudentApplication::all();
    }

    // POST: Submit a new application
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'sex' => 'required|string',
            'birthdate' => 'required|date',
            'mobile_number' => 'required|string',
            'email' => 'required|email',
            'total_parents_gross_income' => 'required|numeric' // Updated name here!
        ]);

        // System Logic: Must flag if income exceeds PhP 400,000.00.
        $isFlagged = $request->total_parents_gross_income > 400000; // Updated name here!

        $application = StudentApplication::create([
            'user_id' => auth()->id(), 
            'name' => $request->name,
            'sex' => $request->sex,
            'birthdate' => $request->birthdate,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'total_parents_gross_income' => $request->total_parents_gross_income, // Updated name here!
            'is_income_flagged' => $isFlagged
        ]);

        return response()->json($application, 201);
    }
    
    // PUT: Update Personal Information
    public function updateProfile(Request $request) {
        // Find the application belonging to the currently logged-in student
        $application = StudentApplication::where('user_id', auth()->id())->first();

        if (!$application) {
            return response()->json(['message' => 'Application not found for this user.'], 404);
        }

        // Update the application with the data sent from Postman
        $application->update($request->only([
            'maiden_name', 'sex', 'birthdate', 'place_of_birth', 
            'mobile_number', 'street', 'barangay', 'municipality', 
            'province', 'zip', 'tribal_membership', 'disability'
        ]));

        return response()->json([
            'message' => 'Personal information updated successfully.', 
            'data' => $application
        ], 200);
    }

    // PUT: Update Academic Profile
    public function updateAcademic(Request $request) {
        $application = StudentApplication::where('user_id', auth()->id())->first();

        if (!$application) {
            return response()->json(['message' => 'Application not found for this user.'], 404);
        }

        $application->update($request->only([
            'school_name', 'school_address', 'school_sector', 
            'student_id_number', 'year_level'
        ]));

        return response()->json([
            'message' => 'Academic profile updated successfully.', 
            'data' => $application
        ], 200);
    }

    // PUT: Update Family & Financial Background
    public function updateFamily(Request $request) {
        $application = StudentApplication::where('user_id', auth()->id())->first();

        if (!$application) {
            return response()->json(['message' => 'Application not found for this user.'], 404);
        }

        // Re-check the flag logic just in case they update their income here
        $isFlagged = $request->total_parents_gross_income > 400000;

        $application->update([
            'father_name' => $request->father_name,
            'father_status' => $request->father_status,
            'father_occupation' => $request->father_occupation,
            'mother_name' => $request->mother_name,
            'mother_status' => $request->mother_status,
            'mother_occupation' => $request->mother_occupation,
            'total_parents_gross_income' => $request->total_parents_gross_income,
            'number_of_siblings' => $request->number_of_siblings,
            'existing_financial_assistance' => $request->existing_financial_assistance,
            'is_income_flagged' => $isFlagged // Update the flag status
        ]);

        return response()->json([
            'message' => 'Family background updated successfully.', 
            'data' => $application
        ], 200);
    }

    // POST: Upload Digital Documents
    public function uploadDocuments(Request $request) {
        $application = StudentApplication::where('user_id', auth()->id())->first();

        if (!$application) {
            return response()->json(['message' => 'Application not found for this user.'], 404);
        }

        // Store the files in the 'public/documents' folder and save the path to the database
        if ($request->hasFile('id_picture')) {
            $application->id_picture_path = $request->file('id_picture')->store('documents', 'public');
        }
        if ($request->hasFile('cor_coe')) {
            $application->cor_coe_path = $request->file('cor_coe')->store('documents', 'public');
        }
        if ($request->hasFile('indigency_certificate')) {
            $application->indigency_certificate_path = $request->file('indigency_certificate')->store('documents', 'public');
        }

        $application->save();

        return response()->json([
            'message' => 'Documents uploaded successfully.',
            'data' => $application
        ], 200);
    }

    // DELETE: Remove an application
    public function destroy($id) {
        return StudentApplication::destroy($id);
    }
}