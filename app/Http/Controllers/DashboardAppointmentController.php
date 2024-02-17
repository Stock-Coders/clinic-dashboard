<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Http\Requests\AppointmentRequest;

class DashboardAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $appointments = Appointment::latest()->get();
            return view('dashboard.appointments.index', compact('appointments'));
        }
        return abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        // if(in_array($authUserEmail, $allowedUsersEmails)){
            $patients = Patient::all();
            $doctors  = User::ofType('doctor')->get();
            return view('dashboard.appointments.create', compact('patients', 'doctors'));
        // }
        // return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentRequest $request)
    {
        try {
            $validatedData = $request->validated();
            Appointment::create($validatedData);
            $patient     = Patient::where('id', $validatedData['patient_id'])->first();
            $patientName = $patient->first_name . ' ' . $patient->last_name;
            return redirect()->route('appointments.index')->with('success', '"'. $patientName .'\'s" appointment has been created successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('appointments.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('dashboard.appointments.show', compact('appointment'));
    }

    public function showIndex(string $id)
    {
        $patient               = Patient::findOrFail($id);
        $appointmentsOfPatient = $patient->appointment()->latest()->get();
        // $appointmentsOfPatient = Appointment::where('patient_id', $patient->id)->latest()->get();
        return view('dashboard.appointments.show-index', compact('patient', 'appointmentsOfPatient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $appointment = Appointment::findOrFail($id);
            $patients    = Patient::all();
            $doctors     = User::ofType('doctor')->get();
            return view('dashboard.appointments.edit', compact('appointment', 'patients', 'doctors'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppointmentRequest $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);
        try {
            $validatedData = $request->validated();
            // Check if any changes have been made to the model's attributes
            $changesDetected = false;
            foreach ($validatedData as $key => $value) {
                if ($appointment->{$key} != $value) {
                    $changesDetected = true;
                    break;
                }
            }
            if (!$changesDetected) {
                return redirect()->route('appointments.edit', $appointment->id)->with('warning', 'No changes were made!');
            }
            $appointment->update($validatedData);
            // Method (1)
                $patientName = $appointment->patient->first_name . ' ' . $appointment->patient->last_name;
            // Method (2)
                // $patient     = Patient::where('id', $validatedData['patient_id'])->first();
                // $patientName = $patient->first_name . ' ' . $patient->last_name;
            return redirect()->route('appointments.index')->with('success', '"'. $patientName .'\'s" appointment has been updated successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('appointments.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $patientName = $appointment->patient->first_name . ' ' . $appointment->patient->last_name;
        try {
            $appointment->delete();
            // Add the session flash here
            session()->flash('AppointmentDestroyMsg', [
                'appointment_soft_delete' => "\"".$patientName."'s\" appointment has been trashed successfully.",
                'appointment_id' => $appointment->id,
            ]);
            return redirect()->route('appointments.index');

            // $appointment->delete();
            // return redirect()->route('appointments.index')->with('appointment_soft_delete', "\"".$patientName."'s\" appointment has been trashed successfully.");
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->route('appointments.index')->with('error', 'Something went wrong!');
        }
    }

    public function trash()
    {
        $appointments = Appointment::onlyTrashed()->latest()->get();
        return view('dashboard.appointments.trash', compact('appointments'));

    }

    public function restore(string $id)
    {
        $appointment = Appointment::withTrashed()->findOrFail($id);
        try {
            $appointment->restore();
            $appointment = Appointment::findOrFail($id);
            $patientName = $appointment->patient->first_name . ' ' . $appointment->patient->last_name;
            $appointment->updated_at = null;
            $appointment->save();

            session()->flash('AppointmentRestoreMsg', [
                'appointment_restore' => "\"".$patientName."'s\" appointment (ID: $appointment->id) has been restored successfully.",
                'appointment_id' => $appointment->id,
            ]);
            return redirect()->route('appointments.index');

            // return redirect()->back()->with('success', "\"".$patientName."'s\" appointment (ID: $appointment->id) has been restored successfully.");
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function forceDelete(string $id)
    {
        $appointment = Appointment::where('id', $id);
        try {
            $appointment->forceDelete();
            return redirect()->route('appointments.trash')->with('success', "The appointment has been permanently deleted successfully.");
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->route('appointments.trash')->with('error', 'Something went wrong!');
        }
    }
}
