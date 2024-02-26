<?php

namespace App\Http\Controllers;

use App\Models\PrescriptionTreatment;
use App\Http\Requests\PrescriptionTreatmentRequest;

class DashboardPrescriptionTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authUserEmail = auth()->user()->email;
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        if(in_array($authUserEmail, $allowedUsersEmails) || auth()->user()->user_type == "doctor"){
            $prescriptionsTreatments = PrescriptionTreatment::latest()->get();
            return view('dashboard.prescriptions-treatments.index', compact('prescriptionsTreatments'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $treatments = \App\Models\Treatment::all();
            return view('dashboard.prescriptions-treatments.create', compact('treatments'));
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrescriptionTreatmentRequest $request)
    {
        try {
            $validatedData = $request->validated();
            PrescriptionTreatment::create($validatedData);
            return redirect()->route('prescriptions-treatments.index')->with('success', 'Treatment\'s prescription has been created successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('prescriptions-treatments.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prescriptionTreatment = PrescriptionTreatment::findOrFail($id);
        return view('dashboard.prescriptions-treatments.show', compact('prescriptionTreatment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prescriptionTreatment = PrescriptionTreatment::findOrFail($id);
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails) || $prescriptionTreatment->create_doctor_id == auth()->user()-id){
            $treatments = \App\Models\Treatment::all();
            return view('dashboard.prescriptions-treatments.edit', compact('prescriptionTreatment', 'treatments'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrescriptionTreatmentRequest $request, string $id)
    {
        $prescriptionTreatment = PrescriptionTreatment::findOrFail($id);
        try {
            $validatedData = $request->validated();
            // Check if any changes have been made to the model's attributes
            $changesDetected = false;
            foreach ($validatedData as $key => $value) {
                if ($prescriptionTreatment->{$key} != $value) {
                    $changesDetected = true;
                    break;
                }
            }
            if (!$changesDetected) {
                return redirect()->route('prescriptions-treatments.edit', $prescriptionTreatment->id)->with('warning', 'No changes were made!');
            }
            $prescriptionTreatment->update($validatedData);
            return redirect()->route('prescriptions-treatments.index')->with('success', 'Treatment\'s prescription has been updated successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('prescriptions-treatments.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prescriptionTreatment = PrescriptionTreatment::findOrFail($id);
        try {
            $prescriptionTreatment->delete();
            return redirect()->route('prescriptions-treatments.index')->with('success', "Treatment's prescription has been deleted successfully.");
        } catch (\Exception $exception) {
            return redirect()->route('prescriptions-treatments.index')->with('error', 'Something went wrong!');
        }
    }
}
