<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\PrescriptionTreatment;

class PrescriptionTreatmentPDFController extends Controller
{
    public function index(){
        $prescriptionsTreatments = PrescriptionTreatment::all();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            return view('dashboard.prescriptions-treatments.pdf.index' , compact('prescriptionsTreatments'));
        }
    }

    public function show(string $id)
    {
        $prescriptionTreatment = PrescriptionTreatment::findOrFail($id);
        return view('dashboard.prescriptions-treatments.pdf.show', compact('prescriptionTreatment'));

    }
}
