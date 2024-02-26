<?php

namespace App\Http\Controllers;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use Illuminate\Support\Facades\Storage;

class DashboardPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        return view('dashboard.patients.index' , compact('patients', 'allowedUsersEmails', 'authUserEmail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
        $authUserEmail = auth()->user()->email;
        return view('dashboard.patients.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        try{
            $validatedData = $request->validated();
            if($validatedData['phone'] == $validatedData['emergency_phone']){
                return redirect()->route('patients.index')->with('error','"Phone Number" and "Emergency Phone" number must be different!');
            }
            // Check if a file is present in the request
            if ($request->hasFile('image')) {
                // Hashed file name
                    // $imageRequest = $request->file('image');
                    // $imageHashedName = $imageRequest->hashName();
                    // $patient = Patient::where('id', $validatedData['id'])->first();
                    // $patientIdAndFullName = $patient->first_name . '_' . $patient->last_name . '_' . $patient->id; // making a directory name with the patient's first_name, last_name & id
                    // $imagePath = Storage::putFileAs('public/assets/dashboard/images/patients/images/$patientIdAndFullName', $imageRequest, $imageHashedName);
                // Actual file name
                    $imageRequest = $request->file('image');
                    $imageName = $imageRequest->getClientOriginalName();
                    $patient = Patient::where('id', $validatedData['id'])->first();
                    $patientIdAndFullName = $patient->first_name . '_' . $patient->last_name . '_' . $patient->id; // making a directory name with the patient's first_name, last_name & id
                    $imagePath = Storage::putFileAs("public/assets/dashboard/images/patients/images/$patientIdAndFullName", $imageRequest, $imageName);
                $validatedData['image'] = $imagePath;
            }
            Patient::create($validatedData);
            return redirect()->route('patients.index')->with('success', '"'.$validatedData['first_name']." ".$validatedData['last_name'].'" has been created successfully.');
            // return redirect()->route('patients.index')->with('success',' has been created successfully.');
        }catch (\Exception $exception){
            dump($exception);
            return redirect()->route('patients.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::findOrFail($id);
        $patientAppointments = $patient->appointment()->latest()->get();
        // $patientAppointments = \App\Models\Appointment::where('patient_id', $patient->id)->latest()->get(); // getting all the appointments of the specified patient

        $totalPatientTreatmentsCount = 0; // Initialize counts, for counting the patient's treatments wether directly (patient-to-appointment-to-treatment) or indirectly (patient-to-appointment-to-prescription-to-treatment)

        // Eager load relationships efficiently
        $patient->load([
            'appointment.treatment',
            'appointment.prescription.treatment'
        ]);

        // Flatten collections efficiently
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
        // Combine treatments while preserving sort order (descending) for the "created_at" column
        $allPatientTreatments = $directTreatments->merge($indirectTreatments)->sortByDesc('created_at');
        return view('dashboard.patients.show', compact('patient', 'patientAppointments', 'totalPatientTreatmentsCount', 'allPatientTreatments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('dashboard.patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, string $id)
    {
        $patient = Patient::findOrFail($id);
        try{
            $validatedData = $request->validated();
            // Check if any changes have been made to the model's attributes
            $changesDetected = false;
            foreach ($validatedData as $key => $value) {
                if ($patient->{$key} != $value) {
                    $changesDetected = true;
                    break;
                }
            }
            if (!$changesDetected) {
                return redirect()->route('patients.edit', $patient->id)->with('warning', 'No changes were made!');
            }
            if($validatedData['phone'] == $validatedData['emergency_phone']){
                return redirect()->route('patients.index')->with('error','Phone number and emergency phone number must be different!');
            }
            // Check if a file is present in the request
            if ($request->hasFile('image')) {
                // Hashed file name
                    // $imageRequest = $request->file('image');
                    // $imageHashedName = $imageRequest->hashName();
                    // $patient = Patient::where('id', $patient->id)->first();
                    // $patientIdAndFullName = $patient->first_name . '_' . $patient->last_name . '_' . $patient->id; // making a directory name with the patient's first_name, last_name & id
                    // $imagePath = Storage::putFileAs('public/assets/dashboard/images/patients/images/$patientIdAndFullName', $imageRequest, $imageHashedName);
                // Actual file name
                    $imageRequest = $request->file('image');
                    $imageName = $imageRequest->getClientOriginalName();
                    $patient = Patient::where('id', $patient->id)->first();
                    $patientIdAndFullName = $patient->first_name . '_' . $patient->last_name . '_' . $patient->id; // making a directory name with the patient's first_name, last_name & id
                    $imagePath = Storage::putFileAs("public/assets/dashboard/images/patients/images/$patientIdAndFullName", $imageRequest, $imageName);
                $validatedData['image'] = $imagePath;

                // Delete the old image if needed, you can customize this part based on your requirements
                // Storage::delete($patient->image);
            }
            $patient->update($validatedData);
            return redirect()->route('patients.index')->with('success', '"'.$validatedData['first_name']." ".$validatedData['last_name'].'" has been updated successfully.');
            // return redirect()->route('patients.index')->with('success',' has been created successfully.');
        }catch (\Exception $exception){
            dump($exception);
            return redirect()->route('patients.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::findOrFail($id);
        try {
            $patient->delete();
            return redirect()->route('patients.index')->with('success', '"'. $patient->first_name ." ". $patient->last_name .'" has been deleted successfully.');
        } catch (\Exception $exception) {
            return redirect()->route('patients.index')->with('error', 'Something went wrong!');
        }
    }
}
