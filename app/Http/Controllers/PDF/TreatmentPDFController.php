<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use App\Models\Patient;

class TreatmentPDFController extends Controller
{
    public function index(){
        $treatments = Treatment::all();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            return view('dashboard.treatments.pdf.index' , compact('treatments'));
        }
    }

    public function showIndex(string $id)
    {
        $patient = Patient::findOrFail($id);
        $patientAppointments = $patient->appointment()->latest()->get();
        $patientAppointmentsCount = $patientAppointments->count();
        $totalPatientTreatmentsCount = 0;
        $patient->load([
            'appointment.treatment',
            'appointment.prescription.treatment'
        ]);
        $directTreatments   = collect();
        $indirectTreatments = collect();
        foreach ($patientAppointments as $patientAppointment) {
            // Direct treatments (patient-to-appointment-to-treatment)
            if ($patientAppointment->treatment) {
                $totalPatientTreatmentsCount++;
                $directTreatments = $directTreatments->merge($patientAppointment->treatment); // getting all the DIRECT treatments of the specified patient
            }

            // Indirect treatments (patient-to-appointment-to-prescription-to-treatment)
            if ($patientAppointment->prescription && $patientAppointment->prescription->treatment) {
                $totalPatientTreatmentsCount += $patientAppointment->prescription->treatment->count();
                $indirectTreatments = $indirectTreatments->merge($patientAppointment->prescription->treatment); // getting all the INDIRECT treatments of the specified patient
            }
        }
        $allPatientTreatments = $directTreatments->merge($indirectTreatments)->sortByDesc('created_at');
        return view('dashboard.treatments.pdf.show-index', compact('patient', 'patientAppointmentsCount', 'totalPatientTreatmentsCount', 'allPatientTreatments'));
    }

    public function show(string $id)
    {
        $treatment = Treatment::findOrFail($id);
        return view('dashboard.treatments.pdf.show', compact('treatment'));
    }
}
