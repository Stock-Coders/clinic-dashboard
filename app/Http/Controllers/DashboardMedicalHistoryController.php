<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Http\Requests\MedicalHistoryRequest;

class DashboardMedicalHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicalHistories   = MedicalHistory::all();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail      = auth()->user()->email;
        return view('dashboard.medical-histories.index', compact('medicalHistories', 'allowedUsersEmails', 'authUserEmail'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $appointments = \App\Models\Appointment::all();
            $prescriptions = \App\Models\Prescription::all();
            $treatments = \App\Models\Treatment::all();
            $prescriptionsTreatments = \App\Models\PrescriptionTreatment::all();

            return view('dashboard.medical-histories.create', compact('appointments' ,'prescriptions','treatments','prescriptionsTreatments'));
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicalHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
          //
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $medicalHistory = MedicalHistory::findOrFail($id);
            $appointments = \App\Models\Appointment::all();
            $prescriptions = \App\Models\Prescription::all();
            $treatments = \App\Models\Treatment::all();
            $prescriptionsTreatments = \App\Models\PrescriptionTreatment::all();
            return view('dashboard.medical-histories.edit', compact('medicalHistory','appointments' ,'prescriptions','treatments','prescriptionsTreatments'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicalHistoryRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = MedicalHistory::findOrFail($id);
        $patientName = $appointment->patient->first_name . ' ' . $appointment->patient->last_name;
        try {
            $appointment->delete();
            // Add the session flash here
            session()->flash('medicalHistoryDestroyMsg', [
                'medical_history_soft_delete' => "\"".$patientName."'s\" appointment has been trashed successfully.",
                'medical_history_id' => $appointment->id,
            ]);
            return redirect()->route('medical-histories.index');

            // $appointment->delete();
            // return redirect()->route('medical-histories.index')->with('medical_history_soft_delete', "\"".$patientName."'s\" appointment has been trashed successfully.");
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->route('medical-histories.index')->with('error', 'Something went wrong!');
        }
    }

    public function trash()
    {
        $appointments = MedicalHistory::onlyTrashed()->latest()->get();
        return view('dashboard.medical-histories.trash', compact('appointments'));

    }

    public function restore(string $id)
    {
        $appointment = MedicalHistory::withTrashed()->findOrFail($id);
        try {
            $appointment->restore();
            $appointment = MedicalHistory::findOrFail($id);
            $patientName = $appointment->patient->first_name . ' ' . $appointment->patient->last_name;
            $appointment->updated_at = null;
            $appointment->save();

            session()->flash('medicalHistoryRestoreMsg', [
                'medical_history_restore' => "\"".$patientName."'s\" appointment (ID: $appointment->id) has been restored successfully.",
                'medical_history_id' => $appointment->id,
            ]);
            return redirect()->route('medical-histories.index');

            // return redirect()->back()->with('success', "\"".$patientName."'s\" appointment (ID: $appointment->id) has been restored successfully.");
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function forceDelete(string $id)
    {
        $appointment = MedicalHistory::where('id', $id);
        try {
            $appointment->forceDelete();
            return redirect()->route('medical-histories.trash')->with('success', "The appointment has been permanently deleted successfully.");
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->route('medical-histories.trash')->with('error', 'Something went wrong!');
        }
    }
}
