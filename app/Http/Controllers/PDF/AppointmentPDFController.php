<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;

class AppointmentPDFController extends Controller
{
    public function index(){
        $appointments = Appointment::all();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            return view('dashboard.appointments.pdf.index' , compact('appointments'));
        }
    }

    public function showIndex(string $id)
    {
        $patient               = Patient::findOrFail($id);
        $appointmentsOfPatient = $patient->appointment()->latest()->get();
        // $appointmentsOfPatient = Appointment::where('patient_id', $patient->id)->latest()->get();
        return view('dashboard.appointments.pdf.show-index', compact('patient', 'appointmentsOfPatient'));
    }

    public function show(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('dashboard.appointments.pdf.show', compact('appointment'));
    }
}
