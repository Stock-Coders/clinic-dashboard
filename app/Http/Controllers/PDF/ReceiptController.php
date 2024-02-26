<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
// use App\Models\Receipt;
// use App\Http\Requests\ReceiptRequest;
use App\Models\Payment;

class ReceiptController extends Controller
{
    public function index()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $payments = Payment::latest()->get();
            return view('dashboard.receipts.pdf.index', compact('payments', 'allowedUsersEmails', 'authUserEmail'));
        }
        return abort(403);
    }

    public function show(string $id)
    {
        $payment = Payment::with('xrays')->findOrFail($id);
        return view('dashboard.receipts.pdf.show', compact('payment'));
    }

    public function showIndex(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $patient         = \App\Models\Patient::findOrFail($id);
            $patientPayments = $patient->payment()->latest()->get();
            // $patientXRays = Payment::where('patient_id', $patient->id)->latest()->get();
            return view('dashboard.receipts.pdf.show-index' , compact('patient', 'patientPayments', 'allowedUsersEmails', 'authUserEmail'));
        }
        return abort(403);
    }
}
