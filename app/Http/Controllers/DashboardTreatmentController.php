<?php

namespace App\Http\Controllers;

use App\Http\Requests\TreatmentRequest;
use App\Models\Treatment;
use App\Models\Appointment;
use App\Models\Prescription;


class DashboardTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatments = Treatment::latest()->get();
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        return view('dashboard.treatments.index' , compact('treatments', 'allowedUsersEmails', 'authUserEmail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $appointments  = Appointment::all();
            $prescriptions = Prescription::all();
            $materials     = \App\Models\Material::all();
            return view('dashboard.treatments.create', compact('appointments', 'prescriptions', 'materials'));
        }
        return abort(403);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(TreatmentRequest $request)
    {
        try{
            $validatedData = $request->validated();
            if(!empty($validatedData['prescription_id']) && !empty($validatedData['appointment_id'])){
                return redirect()->route('treatments.create')->with('error', 'You can\'t add "Prescription" and "Appointment" at the same time! Please fill one field of them only.');
            }
            if(empty($validatedData['prescription_id']) && empty($validatedData['appointment_id'])){
                return redirect()->route('treatments.create')->with('error', 'You can\'t leave the "Prescription" and "Appointment" fields empty! Please fill one field of them only.');
            }
            // If the "prescription_id" request is not empty, then check if it exists (if not send an "error" message)
            $prescriptionId = $validatedData['prescription_id'];
            if (!empty($prescriptionId)) {
                $prescriptionExists = Prescription::where('id', $prescriptionId)->exists(); // Check if the prescription exists
                if (!$prescriptionExists) {
                    return redirect()->route('treatments.create')->with('error', "The selected prescription does not exist.");
                }
            }
            // If the "appointment_id" request is not empty, then check if it exists (if not send an "error" message)
            $appointmentId = $validatedData['appointment_id'];
            if (!empty($appointmentId)) {
                $appointmentExists = Appointment::where('id', $appointmentId)->exists(); // Check if the appointment exists
                if (!$appointmentExists) {
                    return redirect()->route('treatments.create')->with('error', "The selected appointment does not exist.");
                }
            }
            /************************************************************************/
            // If the "prescription_id" request is not empty, then you can't add a prescription with an associated appointment that was already added before directly from the appointment to the treatment

                // if(!empty($prescriptionId)){
                //     $appointmentTreatmentExists        = Treatment::where('appointment_id', 2)->first();
                //     $prescriptionAssociatedAppointment = Prescription::where('appointment_id', $appointmentTreatmentExists);
                //     // $appointmentExistsInTreatments     = Treatment::where('prescription_id', $prescriptionId)->exists();
                //     if($prescriptionAssociatedAppointment){
                //         return redirect()->route('treatments.create')->with('error', 'Sorry! You can\'t add a "Prescription" with an associated "Appointment" that was already added before directly from the appointment to the treatment.');
                //     }
                // }

                // Check if the appointment associated with the prescription is already added directly to the treatment
                // $appointmentExistsInTreatments = Treatment::where('appointment_id', $appointmentId)->exists();
                // if ($appointmentExistsInTreatments) {
                //     return redirect()->route('treatments.create')->with('error', 'Sorry! You can\'t add a "Prescription" with an associated "Appointment" that was already added before directly from the appointment to the treatment.');
                // }
            /************************************************************************/
            if(
            (!empty($validatedData['prescription_id']) && empty($validatedData['appointment_id'])) ||
            (empty($validatedData['prescription_id']) && !empty($validatedData['appointment_id']))
            ){
                $treatment = Treatment::create($validatedData);
                if ($request->has('materials')) {
                    foreach ($request->input('materials') as $materialId => $quantity) {
                        $quantityFromRequest = $request->input('quantities.' . $materialId); // Retrieve quantity from request
                        $material = \App\Models\Material::findOrFail($materialId);
                        $totalCost = $treatment->cost + ($material->cost * $quantityFromRequest);

                        // Deduct the quantity from the material's table only if the treatment creation was successful
                        if ($treatment->wasRecentlyCreated) {
                            $material->quantity -= $quantityFromRequest;
                            if($material->quantity <= 0 || $material->quantity == null){ //  If material is out of stock (resulted from the request), or the material's quantity is already null, then set the material's quantity to null.
                                $material->quantity = null;
                            }
                            elseif($quantityFromRequest > $material->quantity){
                                return redirect()->route('treatments.index')->with('error', 'The treatment is successfully created but, the quantity that you entered for the material(s) is greater than the available quantity.');
                            }
                            $material->save();
                        }

                        // Attach material with quantity and total cost
                        $treatment->materials()->attach($materialId, [
                            'material_quantity' => $quantityFromRequest,
                            'total_cost'        => $totalCost
                        ]);
                    }
                }
                // Check if at least one material is selected
                // if (!$request->has('materials')) {
                //     return redirect()->back()->with('error', 'At least one material must be selected.');
                // }

                // // Check if all quantities are provided
                // $quantities = $request->input('quantities', []);
                // foreach ($quantities as $quantity) {
                //     if (empty($quantity)) {
                //         return redirect()->back()->with('error', 'The quantity field is required for all materials.');
                //     }
                // }

                // // Check if all quantities are integers and greater than 0
                // foreach ($quantities as $quantity) {
                //     if (!is_numeric($quantity) || $quantity <= 0) {
                //         return redirect()->back()->with('error', 'The quantity must be a positive integer for all materials.');
                //     }
                // }
                if($treatment->prescription_id != null && $treatment->appointment_id == null){
                    $patientName = $treatment->prescription->appointment->patient->first_name . ' ' . $treatment->prescription->appointment->patient->last_name;
                }else{ // elseif($treatment->prescription_id == null && $treatment->appointment_id != null)
                    $patientName = $treatment->appointment->patient->first_name . ' ' . $treatment->appointment->patient->last_name;
                }
                return redirect()->route('treatments.index')->with('success', $patientName.'\'s treatment has been created successfully.');
            }
        }catch (\Exception $exception){
            // Check if the treatment object exists
            if (isset($treatment) && $treatment->wasRecentlyCreated) {
                // Restore quantities of materials if a treatment was created before the error
                foreach ($treatment->materials as $material) {
                    $quantity = $material->pivot->material_quantity;
                    $material->quantity += $quantity;
                    $material->save();
                }
            }
            dump($exception);
            return redirect()->route('treatments.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $treatment = Treatment::findOrFail($id);
        return view('dashboard.treatments.show', compact('treatment'));
    }

    // public function showIndex(string $id)
    // {
    //     $patient = \App\Models\Patient::findOrFail($id);

    //     // Retrieve appointments associated with the patient
    //     $patientAppointments = $patient->appointment;

    //     // Retrieve treatments directly associated with the appointments
    //     $treatmentsFromAppointments = collect();
    //     foreach ($patientAppointments as $patientAppointment) {
    //         $treatmentsFromAppointments = $treatmentsFromAppointments->merge($patientAppointment->treatment);
    //     }

    //     // Retrieve prescriptions associated with the appointments
    //     $prescriptions = collect();
    //     foreach ($patientAppointments as $patientAppointment) {
    //         $prescriptions = $prescriptions->merge($patientAppointment->prescription);
    //     }

    //     // dump($treatmentsFromAppointments);

    //     // Check if prescriptions exist and not null
    //     if ($prescriptions && !$prescriptions->isEmpty()) {
    //         // Retrieve treatments associated with these prescriptions
    //         $treatmentsFromPrescriptions = collect();
    //         foreach ($prescriptions as $prescription) {
    //             // Assuming each prescription can have multiple treatments
    //             $treatmentsFromPrescriptions = $treatmentsFromPrescriptions->merge($prescription->treatment);
    //         }
    //     } else {
    //         $treatmentsFromPrescriptions = collect(); // Initialize empty collection if no prescriptions
    //     }

    //     // Merge treatments from both sources
    //     $allPatientTreatments = $treatmentsFromAppointments->merge($treatmentsFromPrescriptions);

    //     // Sort treatments by date
    //     $allPatientTreatments = $allPatientTreatments->sortByDesc('created_at');

    //     return view('dashboard.treatments.show-index', compact('patient', 'allPatientTreatments'));
    // }

    public function showIndex(string $id)
    {
        $patient = \App\Models\Patient::findOrFail($id);

        // Retrieve appointments associated with the patient
        $patientAppointments = $patient->appointment;

        // Retrieve treatments directly associated with the appointments
        $treatmentsFromAppointments = collect();
        foreach ($patientAppointments as $patientAppointment) {
            $treatmentsFromAppointments = $treatmentsFromAppointments->merge($patientAppointment->treatment);
        }

        // Retrieve prescriptions associated with the appointments
        $prescriptions = collect();
        foreach ($patientAppointments as $patientAppointment) {
            $prescriptions = $prescriptions->merge($patientAppointment->prescription);
        }

        // Check if prescriptions exist and not null
        if ($prescriptions && !$prescriptions->isEmpty()) {
            // Retrieve treatments associated with these prescriptions
            $treatmentsFromPrescriptions = collect();
            foreach ($prescriptions as $prescription) {

                $test = Treatment::whereNull('appointment_id')->whereNotNull('prescription_id')
                ->where('prescription_id', $prescription->id)
                ->distinct()->get();
                $treatmentsFromPrescriptions = $treatmentsFromPrescriptions->merge($test);

                // Ensure $prescription is an object
                // if (is_object($prescription) && isset($prescription->id)) {
                //     // Retrieve treatments associated with the prescription ID
                //     $test = Treatment::whereNull('appointment_id')
                //                     ->where('prescription_id', $prescription->id)
                //                     ->distinct()->get();
                //     $treatmentsFromPrescriptions = $treatmentsFromPrescriptions->merge($test);
                // }
            }
        }
        else {
            $treatmentsFromPrescriptions = collect(); // Initialize empty collection if no prescriptions
        }

        // Merge treatments from both sources
        $allPatientTreatments = $treatmentsFromAppointments->merge($treatmentsFromPrescriptions);

        // Sort treatments by date
        $allPatientTreatments = $allPatientTreatments->sortByDesc('created_at');

        return view('dashboard.treatments.show-index', compact('patient', 'allPatientTreatments'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $treatment     = Treatment::with('materials')->findOrFail($id);
            $appointments  = Appointment::all();
            $prescriptions = Prescription::all();
            $materials     = \App\Models\Material::all();
            return view('dashboard.treatments.edit', compact('treatment', 'appointments', 'prescriptions', 'materials'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TreatmentRequest $request, string $id)
    {
        $treatment = Treatment::findOrFail($id);
        try{
            $validatedData = $request->validated();
            // Check if any changes have been made to the model's attributes
                // $changesDetected = false;
                // $validatedData = $request->validated();
                // foreach ($validatedData as $key => $value) {
                //     if ($treatment->{$key} != $value) {
                //         $changesDetected = true;
                //         break;
                //     }
                // }
                // if (!$changesDetected) {
                //     return redirect()->route('treatments.edit', $treatment->id)->with('warning', 'No changes were made!');
                // }
            if(!empty($validatedData['prescription_id']) && !empty($validatedData['appointment_id'])){
                return redirect()->route('treatments.edit', $treatment->id)->with('error', 'You can\'t add "Prescription" and "Appointment" at the same time! Please fill one field of them only.');
            }
            if(empty($validatedData['prescription_id']) && empty($validatedData['appointment_id'])){
                return redirect()->route('treatments.edit', $treatment->id)->with('error', 'You can\'t leave the "Prescription" and "Appointment" fields empty! Please fill one field of them only.');
            }
            // If the "prescription_id" request is not empty, then check if it exists (if not send an "error" message)
            $prescriptionId = $validatedData['prescription_id'];
            if (!empty($prescriptionId)) {
                $prescriptionExists = Prescription::where('id', $prescriptionId)->exists(); // Check if the prescription exists
                if (!$prescriptionExists) {
                    return redirect()->route('treatments.create')->with('error', "The selected prescription does not exist.");
                }
            }
            // If the "appointment_id" request is not empty, then check if it exists (if not send an "error" message)
            $appointmentId = $validatedData['appointment_id'] ?? null; // null, To skip it if the "appointment_id" request is not provided (which also means, when submitting a prescription)
            if (!empty($appointmentId)) {
                $appointmentExists = Appointment::where('id', $appointmentId)->exists(); // Check if the appointment exists
                if (!$appointmentExists) {
                    return redirect()->route('treatments.create')->with('error', "The selected appointment does not exist.");
                }
            }
            if(
            (!empty($validatedData['prescription_id']) && empty($validatedData['appointment_id'])) ||
            (empty($validatedData['prescription_id']) && !empty($validatedData['appointment_id']))
            ){
                $treatment->update($validatedData);
                // Sync materials with total cost
                if ($request->has('materials')) {
                    $totalCost = $treatment->cost; // Initialize with treatment cost
                    foreach ($request->input('materials') as $materialId) {
                        $material = \App\Models\Material::findOrFail($materialId);
                        $totalCost += $material->cost;
                    }
                    // $treatment->materials()->sync($request->input('materials'), ['total_cost' => $totalCost]);

                    // Sync materials
                    $treatment->materials()->sync($request->input('materials'));
                    // Update total_cost for each pivot record
                    foreach ($request->input('materials') as $materialId) {
                        $material = \App\Models\Material::findOrFail($materialId);
                        $treatment->materials()->updateExistingPivot($materialId, ['total_cost' => $totalCost]);
                    }
                } else {
                    // If no materials are provided, detach all materials
                    $treatment->materials()->detach();
                }
                if($treatment->prescription_id != null && $treatment->appointment_id == null){
                    $patientName = $treatment->prescription->appointment->patient->first_name . ' ' . $treatment->prescription->appointment->patient->last_name;
                }else{ // elseif($treatment->prescription_id == null && $treatment->appointment_id != null)
                    $patientName = $treatment->appointment->patient->first_name . ' ' . $treatment->appointment->patient->last_name;
                }
                return redirect()->route('treatments.index')->with('success', $patientName.'\'s treatment has been updated successfully.');
            }
        }catch (\Exception $exception){
            dump($exception);
            return redirect()->route('treatments.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $treatment = Treatment::findOrFail($id);
        try {
            if($treatment->prescription_id != null && $treatment->appointment_id == null){
                $patientName = $treatment->prescription->appointment->patient->first_name . ' ' . $treatment->prescription->appointment->patient->last_name;
            }else{ // elseif($treatment->prescription_id == null && $treatment->appointment_id != null)
                $patientName = $treatment->appointment->patient->first_name . ' ' . $treatment->appointment->patient->last_name;
            }
            // Get the materials associated with the treatment
            $materials = $treatment->materials;

            // Detach the treatment from all materials
            $treatment->materials()->detach();

            // Restore the quantities of materials
            foreach ($materials as $material) {
                // Increase the quantity of each material by the amount used in this treatment
                $material->quantity += $material->pivot->material_quantity;
                $material->save();
            }
            $treatment->delete();
            return redirect()->route('treatments.index')->with('success', $patientName.'\'s treatment has been deleted successfully.');
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->route('treatments.index')->with('error', 'Something went wrong!');
        }
    }
}
