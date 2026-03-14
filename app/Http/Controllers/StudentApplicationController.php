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
            'parents_gross_income' => 'required|numeric'
        ]);

        // System Logic: Must flag if income exceeds PhP 400,000.00. [cite: 20]
        $isFlagged = $request->parents_gross_income > 400000;

        $application = StudentApplication::create([
            'user_id' => auth()->id(), // Links to the logged-in user
            'name' => $request->name,
            'sex' => $request->sex,
            'birthdate' => $request->birthdate,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'parents_gross_income' => $request->parents_gross_income,
            'is_income_flagged' => $isFlagged
        ]);

        return response()->json($application, 201);
    }
    
    // DELETE: Remove an application
    public function destroy($id) {
        return StudentApplication::destroy($id);
    }
}