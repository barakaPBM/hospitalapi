<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PatientController extends Controller
{
    //
    public function register(Request $request)
    {
        $validated = $request->validate([
            'Sponsor_ID' => 'required',
            'Patient_Name' => 'required|string',
            'Date_Of_Birth' => 'required|date',
            'Gender' => 'required|string',
            'Visit_Type_ID' => 'required',
            'Type_Of_Check_In' => 'required',
            'branchId' => 'required',
            'Employee_ID' => 'required',
            'pf3' => 'nullable',
            'Diceased' => 'required|string',
            'Referral_Status' => 'nullable'
        ]);

        $response = Http::post('http://41.188.172.204:3033/patient-registration', $validated);

        if ($response->successful()) {
            return response()->json([
                'message' => 'Patient registered successfully.',
                'Check_In_Date_And_Time' => $response['Check_In_Date_And_Time'] ?? null
            ]);
        }

        return response()->json([
            'message' => 'Failed to register patient.',
            'error' => $response->body(),
        ], $response->status());
    }
}
