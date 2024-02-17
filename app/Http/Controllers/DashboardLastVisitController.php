<?php

namespace App\Http\Controllers;

use App\Models\LastVisit;
use App\Models\Patient;
use App\Http\Requests\LastVisitRequest;

class DashboardLastVisitController extends Controller
{
    public function index(){
        $lastVisits = LastVisit::orderBy('last_visit_date', 'desc')->orderBy('patient_id', 'asc')->get();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        return view('dashboard.last-visits.index', compact('lastVisits', 'allowedUsersEmails', 'authUserEmail'));
    }

    public function create(string $id){
        $patient  = Patient::findOrFail($id); // For each patient single page (show) by id 
        $patients = Patient::all(); // For fetching all the patients in the form for "patient_id" field
        return view('dashboard.last-visits.create', compact('patient', 'patients'));
    }

    public function show(string $id){
        $patient            = Patient::findOrFail($id);
        $patientLastVisits  = \App\Models\LastVisit::orderBy('last_visit_date', 'desc')->where('patient_id', $patient->id)->get();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail      = auth()->user()->email;
        return view('dashboard.last-visits.patient-last-visits', compact('patient', 'patientLastVisits', 'allowedUsersEmails', 'authUserEmail'));

    }

    public function store(LastVisitRequest $request){
        try {
            $validatedData = $request->validated();
            LastVisit::create($validatedData);
            return redirect()->route('patients.lastVisitsIndex')->with('success', 'Last visit has been added successfully.');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('patients.lastVisitsIndex')->with('error', 'Something went wrong!');
        }
    }

    public function destroy(string $id)
    {
        $lastVisit = LastVisit::findOrFail($id);
        try {
            $lastVisit->delete();
            return redirect()->route('patients.lastVisitsIndex')->with('success', "Last visit has been deleted successfully.");
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->route('patients.lastVisitsIndex')->with('error', 'Something went wrong!');
        }
    }
}
