<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnalysisRequest;
use App\Models\Analysis;
use App\Models\User;
use App\Models\Patient;

class DashboardAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $analyses = Analysis::latest()->get();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        return view('dashboard.analyses.index' , compact('analyses', 'allowedUsersEmails', 'authUserEmail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $doctors  = User::ofType('doctor')->get();
            $patients = Patient::all();
            return view('dashboard.analyses.create', compact('doctors', 'patients'));
        }
        return abort(403);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(AnalysisRequest $request)
    {
        try{
            $validatedData = $request->validated();
            Analysis::create($validatedData);
            $patient     = Patient::where('id', $validatedData['patient_id'])->first();
            $patientName = $patient->first_name . ' ' . $patient->last_name;
            return redirect()->route('analyses.index')->with('success', 'Analysis for "'.$patientName.'" has been created successfully.');
        }catch (\Exception $exception){
            dump($exception);
            return redirect()->route('analyses.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $analysis = Analysis::findOrFail($id);
        return view('dashboard.analyses.show', compact('analysis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $analysis = Analysis::findOrFail($id);
            $doctors  = User::ofType('doctor')->get();
            $patients = Patient::all();
            return view('dashboard.analyses.edit', compact('analysis', 'doctors', 'patients'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnalysisRequest $request, string $id)
    {
        $analysis = Analysis::findOrFail($id);
        try{
            $validatedData = $request->validated();
            // Check if any changes have been made to the model's attributes
            $changesDetected = false;
            foreach ($validatedData as $key => $value) {
                if ($analysis->{$key} != $value) {
                    $changesDetected = true;
                    break;
                }
            }
            if (!$changesDetected) {
                return redirect()->route('analyses.edit', $analysis->id)->with('warning', 'No changes were made!');
            }
            $analysis->update($validatedData);
            $patient     = Patient::where('id', $validatedData['patient_id'])->first();
            $patientName = $patient->first_name . ' ' . $patient->last_name;
            return redirect()->route('analyses.index')->with('success', 'Analysis for "'.$patientName.'" has been updated successfully.');
        }catch (\Exception $exception){
            dump($exception);
            return redirect()->route('analyses.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $analysis = Analysis::findOrFail($id);
        try {
            $analysis->delete();
            return redirect()->route('analyses.index')->with('success', '"'. $analysis->patient->first_name ." ". $analysis->patient->last_name .'"\'s analysis (ID: '.$analysis->id.') has been deleted successfully.');
        } catch (\Exception $exception) {
            return redirect()->route('analyses.index')->with('error', 'Something went wrong!');
        }
    }
}
