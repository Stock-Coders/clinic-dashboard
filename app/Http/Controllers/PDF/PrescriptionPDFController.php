<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\Prescription;

class PrescriptionPDFController extends Controller
{
    public function index(){
        $prescriptions = Prescription::all();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails) || auth()->user()->user_type == "employee"){
            return view('dashboard.prescriptions.pdf.index' , compact('prescriptions'));
        }
    }

    public function show(string $id)
    {
        $prescription = Prescription::findOrFail($id);
        return view('dashboard.prescriptions.pdf.show', compact('prescription'));

    }
}
