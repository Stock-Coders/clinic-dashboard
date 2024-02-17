<?php

namespace App\Http\Controllers;
use App\Http\Requests\XRayRequest;
use App\Models\XRay;
use Illuminate\Support\Facades\Storage;

class DashboardXRayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $xrays = XRay::latest()->get();
            return view('dashboard.x-rays.mass.index' , compact('xrays'));
        }
        return abort(403);
    }

    public function indexSingle(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $patient = \App\Models\Patient::findOrFail($id);
            $patientXRays = $patient->xray()->latest()->get();
            // $patientXRays = XRay::where('patient_id', $patient->id)->latest()->get();
            return view('dashboard.x-rays.single.single-index' , compact('patient', 'patientXRays'));
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
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $patients = \App\Models\Patient::all();
            return view('dashboard.x-rays.mass.create', compact('patients'));
        }
        return abort(403);
    }

    public function createSingle(string $id)
    {

        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $patient = \App\Models\Patient::findOrFail($id);
            return view('dashboard.x-rays.single.single-create', compact('patient'));
        }
        return abort(403);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(XRayRequest $request)
    {
        try{
            $validatedData = $request->validated();
            // Check if a file is present in the request
            if ($request->hasFile('image')) {
                // Hashed file name
                    // $imageRequest = $request->file('image')
                    // $imageHashedName = $imageRequest->hashName();
                    // $patient = \App\Models\Patient::where('id', $validatedData['patient_id'])->first();
                    // $patientIdAndFullName = $patient->first_name . '_' . $patient->last_name . '_' . $patient->id; // making a directory name with the patient's first_name, last_name & id
                    // $imagePath = Storage::putFileAs('public/assets/dashboard/images/patients/X-rays/$patientIdAndFullName', $imageRequest, $imageHashedName);
                // Actual file name
                    $imageRequest = $request->file('image');
                    $imageName = $imageRequest->getClientOriginalName();
                    $patient = \App\Models\Patient::where('id', $validatedData['patient_id'])->first();
                    $patientIdAndFullName = $patient->first_name . '_' . $patient->last_name . '_' . $patient->id; // making a directory name with the patient's first_name, last_name & id
                    $imagePath = Storage::putFileAs("public/assets/dashboard/images/patients/X-rays/$patientIdAndFullName", $imageRequest, $imageName);
                $validatedData['image'] = $imagePath;
            }
            XRay::create($validatedData);
            $patientFullName = $patient->first_name . ' ' . $patient->last_name;
            return redirect()->route('x-rays.index')->with('success', 'X-ray "'.$validatedData['title'].'" has been created successfully for ('.$patientFullName.').');
        }catch (\Exception $exception){
            dump($exception);
            return redirect()->route('x-rays.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $xray = XRay::findOrFail($id);
            return view('dashboard.x-rays.show' , compact('xray'));
        }
        return abort(403);
    }

    public function patientGallery(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $patient               = \App\Models\Patient::findOrFail($id);
            $patientXRaysBefore    = $patient->xray()->where('timing', 'before')->latest()->get();
            $patientXRaysInBetween = $patient->xray()->where('timing', 'in_between')->latest()->get();
            $patientXRaysAfter     = $patient->xray()->where('timing', 'after')->latest()->get();
            // $patientXRays = XRay::where('patient_id', $patient->id)->latest()->get();
            $combinedXRaysTiming = $patientXRaysBefore->concat($patientXRaysInBetween)->concat($patientXRaysAfter); // Merge the three collections into one

            return view('dashboard.x-rays.patient-gallery' , compact('patient', 'patientXRaysBefore', 'patientXRaysAfter', 'patientXRaysInBetween', 'combinedXRaysTiming'));
        }
        return abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $xray = XRay::findOrFail($id);
            $p_f_name = $xray->patient->first_name;
            $p_l_name = $xray->patient->last_name;
            $patients = \App\Models\Patient::all();
            return view('dashboard.x-rays.mass.edit' , compact('xray', 'patients', 'p_f_name', 'p_l_name'));
        }
        return abort(403);
    }

    public function editSingle(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $xray = XRay::findOrFail($id);
            $patient = \App\Models\Patient::findOrFail($id);
        return view('dashboard.x-rays.single.single-edit' , compact('xray', 'patient'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(XRayRequest $request, string $id)
    {
        $xray = XRay::findOrFail($id);
        try{
            $validatedData = $request->validated();
             // Check if any changes have been made to the model's attributes
             $changesDetected = false;
             foreach ($validatedData as $key => $value) {
                 if ($xray->{$key} != $value) {
                     $changesDetected = true;
                     break;
                 }
             }
             if (!$changesDetected) {
                 return redirect()->route('x-rays.edit', $xray->id)->with('warning', 'No changes were made!');
             }
            // Check if a file is present in the request
            if ($request->hasFile('image')) {
                // Hashed file name
                    // $imageRequest = $request->file('image')
                    // $imageHashedName = $imageRequest->hashName();
                    // $patient = \App\Models\Patient::where('id', $validatedData['patient_id'])->first();
                    // $patientIdAndFullName = $patient->first_name . '_' . $patient->last_name . '_' . $patient->id; // making a directory name with the patient's first_name, last_name & id
                    // $imagePath = Storage::putFileAs('public/assets/dashboard/images/patients/X-rays/$patientIdAndFullName', $imageRequest, $imageHashedName);
                // Actual file name
                    $imageRequest = $request->file('image');
                    $imageName = $imageRequest->getClientOriginalName();
                    $patient = \App\Models\Patient::where('id', $validatedData['patient_id'])->first();
                    $patientIdAndFullName = $patient->first_name . '_' . $patient->last_name . '_' . $patient->id; // making a directory name with the patient's first_name, last_name & id
                    $imagePath = Storage::putFileAs("public/assets/dashboard/images/patients/X-rays/$patientIdAndFullName", $imageRequest, $imageName);
                $validatedData['image'] = $imagePath;

                // Delete the old image if needed, you can customize this part based on your requirements
                // Storage::delete($xray->image);
            }
            $xray->update($validatedData);
            return redirect()->route('x-rays.index')->with('success', 'X-ray "'.$validatedData['title'].'" with ID ('.$xray->id.') for "'.$xray->patient->first_name.' '.$xray->patient->last_name.'" has been updated successfully.');
        }catch (\Exception $exception){
            dump($exception);
            return redirect()->route('x-rays.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $xray = XRay::findOrFail($id);
        $p_f_name = $xray->patient->first_name;
        $p_l_name = $xray->patient->last_name;
        try {
            $xray->delete();
            return redirect()->route('x-rays.index')->with('success', "\"$xray->title\" with ID ($xray->id) for \"$p_f_name $p_l_name\" has been deleted successfully.");
        } catch (\Exception $exception) {
            return redirect()->route('x-rays.index')->with('error', 'Something went wrong!');
        }
    }

    public function clearAll()
    {
        try {
            $xrays = XRay::all();
            if($xrays->count() >= 1){
                XRay::truncate(); // Faster (because it just deletes all the records of the model)
                // $xrays->each->delete(); // Slower (because it deletes the records one by one individually)
                return redirect()->route('x-rays.index')->with('success', 'All x-rays cleared successfully.');
            } else{
                return redirect()->route('x-rays.index')->with('warning', 'There are no x-rays found in the database already!');
            }
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->route('x-rays.index')->with('error', 'Failed to clear x-rays.');
        }
    }

    public function clearAllForPatient(string $id)
    {
        $patient = \App\Models\Patient::findOrFail($id);
        try {
            $patientXRays = $patient->xray()->get();
            // $patientXRays = XRay::where('patient_id', $patient->id)->get();
            if($patientXRays->count() >= 1){
                $patientXRays->each->delete();
                // XRay::where('patient_id', $patient->id)->truncate();
                return redirect()->route('patient.x-rays.index', $patient->id)->with('success', 'All x-rays cleared successfully for ('.$patient->first_name . ' ' . $patient->last_name.').');
            } else{
                return redirect()->route('patient.x-rays.index', $patient->id)->with('warning', 'There are no x-rays found in the database already for ('.$patient->first_name . ' ' . $patient->last_name.')!');
            }
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->route('patient.x-rays.index', $patient->id)->with('error', 'Failed to clear x-rays.');
        }
    }

}
