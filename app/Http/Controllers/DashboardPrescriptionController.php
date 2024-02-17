<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Http\Requests\PrescriptionRequest;

class DashboardPrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescriptions = Prescription::latest()->get();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        return view('dashboard.prescriptions.index', compact('prescriptions', 'allowedUsersEmails', 'authUserEmail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $appointments = \App\Models\Appointment::all();
            return view('dashboard.prescriptions.create', compact('appointments'));
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PrescriptionRequest $request)
    {
        try {
            $validatedData = $request->validated();
            Prescription::create($validatedData);
            return redirect()->route('prescriptions.index')->with('success', 'Prescription has been created successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('prescriptions.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prescription = Prescription::findOrFail($id);
        return view('dashboard.prescriptions.show', compact('prescription'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prescription = Prescription::findOrFail($id);
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $appointments = \App\Models\Appointment::all();
            return view('dashboard.prescriptions.edit', compact('prescription', 'appointments'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PrescriptionRequest $request, string $id)
    {
        $prescription = Prescription::findOrFail($id);
        try {
            $validatedData = $request->validated();
             // Check if any changes have been made to the model's attributes
             $changesDetected = false;
             foreach ($validatedData as $key => $value) {
                 if ($prescription->{$key} != $value) {
                     $changesDetected = true;
                     break;
                 }
             }
             if (!$changesDetected) {
                 return redirect()->route('prescriptions.edit', $prescription->id)->with('warning', 'No changes were made!');
             }
            $prescription->update($validatedData);
            return redirect()->route('prescriptions.index')->with('success', 'Prescription has been updated successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('prescriptions.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prescription = Prescription::findOrFail($id);
        try {
            $prescription->delete();
            return redirect()->route('prescriptions.index')->with('success', "Prescription has been deleted successfully.");
        } catch (\Exception $exception) {
            return redirect()->route('prescriptions.index')->with('error', 'Something went wrong!');
        }
    }
}
