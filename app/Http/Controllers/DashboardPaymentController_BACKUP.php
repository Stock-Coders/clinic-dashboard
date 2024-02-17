<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Appointment;
use App\Models\Treatment;
use App\Models\PrescriptionTreatment;
use App\Models\XRay;
use App\Http\Requests\PaymentRequest;

class DashboardPaymentController_BACKUP extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $payments = Payment::latest()->get();
            return view('dashboard.payments.mass.index', compact('payments', 'allowedUsersEmails', 'authUserEmail'));
        }
        return abort(403);
    }

    public function indexSingle(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $patient         = \App\Models\Patient::findOrFail($id);
            $patientPayments = $patient->payment()->latest()->get();
            // $patientXRays = Payment::where('patient_id', $patient->id)->latest()->get();
            return view('dashboard.payments.single.single-index' , compact('patient', 'patientPayments', 'allowedUsersEmails', 'authUserEmail'));
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
            $appointments            = Appointment::all();
            $treatments              = Treatment::all();
            $prescriptionsTreatments = PrescriptionTreatment::all();
            $xrays                   = XRay::all();
            $patients                = \App\Models\Patient::all();
            return view('dashboard.payments.mass.create', compact('appointments', 'treatments', 'prescriptionsTreatments', 'xrays', 'patients'));
        }
        return abort(403);
    }

    public function createSingle(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $patient = \App\Models\Patient::findOrFail($id);
            $appointments = $patient->appointment()->get();
            $treatments = collect();
            foreach ($appointments as $appointment) {
                $appointmentTreatments = $appointment->treatment()->get();
                $treatments = $treatments->merge($appointmentTreatments);
            }
            $prescriptionsTreatments = collect();
            foreach ($treatments as $treatment) {
                $prescriptionsOfTreatments = $treatment->prescriptionTreatment()->get();
                $prescriptionsTreatments = $prescriptionsTreatments->merge($prescriptionsOfTreatments);
            }
            $xrays = $patient->xray()->get();
            return view('dashboard.payments.single.single-create', compact('patient', 'appointments', 'treatments', 'prescriptionsTreatments', 'xrays'));
        }
        return abort(403);
    }

    // private function calculateTotalAmount($data)
    // {

    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Calculate total amount
            $totalAmount = 0;

            if (isset($validatedData['appointment_id'])) {
                $appointment  = Appointment::find($validatedData['appointment_id']);
                $totalAmount += $appointment->cost;
            }

            if (isset($validatedData['treatment_id'])) {
                $treatment    = Treatment::find($validatedData['treatment_id']);
                $totalAmount += $treatment->cost;
            }

            if (isset($validatedData['prescription_treatment_id'])) {
                $prescriptionTreatment  = PrescriptionTreatment::find($validatedData['prescription_treatment_id']);
                foreach($prescriptionTreatment->treatment->materials as $material){
                    // $materials Total Cost
                    $totalAmount += $material->pivot->material_quantity * $material->cost;
                }
            }

            if (isset($validatedData['xray_id'])) {
                $xray         = XRay::find($validatedData['xray_id']);
                $totalAmount += $xray->cost;
            }

            $totalAmountBeforeDiscount = $totalAmount; // Handling the total amount before the discount (wether if there is an existing discount or not)

            // Apply discount if available
            if (isset($validatedData['discount'])) {
                $totalAmount = $totalAmount - ($totalAmount * ($validatedData['discount'] / 100));
            }

            $appointment = Appointment::find($validatedData['appointment_id']);
            if (!$appointment || $appointment->patient_id != $validatedData['patient_id']) {
                return redirect()->back()->with('error', 'The patient you selected is not the same patient in the "Appointment"!');
            }

            $treatment = Treatment::find($validatedData['treatment_id']);
            if(isset($validatedData['treatment_id'])){
                if (!$treatment || $treatment->appointment->patient_id != $validatedData['patient_id']) {
                    return redirect()->back()->with('error', 'The patient you selected is not the same patient in the "Treatment"!');
                }
            }

            $prescriptionTreatment = PrescriptionTreatment::find($validatedData['prescription_treatment_id']);
            if(isset($validatedData['prescription_treatment_id'])){
                if (!$prescriptionTreatment || $prescriptionTreatment->treatment->appointment->patient_id != $validatedData['patient_id']) {
                    return redirect()->back()->with('error', 'The patient you selected is not the same patient in the "Treatment\'s Prescription"!');
                }
            }

            // Find the X-ray associated with the appointment's patient
            $xray = XRay::find($validatedData['xray_id']);
            if(isset($validatedData['xray_id'])){
                if (!$xray || $xray->patient_id != $validatedData['patient_id']) {
                    return redirect()->back()->with('error', 'The patient you selected is not the same patient in the "X-ray"!');
                }
            }

            // Method (1): Create payment, then update the "amount" column with the total amount ($totalAmount)
                // // Create payment with validated data
                // $payment = Payment::create($validatedData);

                // // Assign total amount to the amount column
                // $payment->update(['amount_after_discount' => $totalAmount]);

            // Method (2) - faster method: Create payment with total amount
                $payment = Payment::create([
                    'payment_method'            => $validatedData['payment_method'] ?? 'cash',
                    'discount'                  => $validatedData['discount'],
                    'payment_date'              => $validatedData['payment_date'],
                    'payment_time'              => $validatedData['payment_time'],
                    'appointment_id'            => $validatedData['appointment_id'],
                    'treatment_id'              => $validatedData['treatment_id'] ?? null,
                    'prescription_treatment_id' => $validatedData['prescription_treatment_id'] ?? null,
                    'xray_id'                   => $validatedData['xray_id'] ?? null,
                    'patient_id'                => $validatedData['patient_id'],
                    'amount_before_discount'    => $totalAmountBeforeDiscount,
                    'amount_after_discount'     => $totalAmount
                ]);

            return redirect()->back()->with('success', 'Payment (ID: '.$payment->id.') has been created successfully for ('.$payment->appointment->patient->first_name .' '. $payment->appointment->patient->last_name.').');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('payments.index')->with('error', 'Something went wrong!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::findOrFail($id);
        return view('dashboard.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $payment                 = Payment::findOrFail($id);
            $appointments            = Appointment::all();
            $treatments              = Treatment::all();
            $prescriptionsTreatments = PrescriptionTreatment::all();
            $xrays                   = XRay::all();
            $patients                = \App\Models\Patient::all();
            return view('dashboard.payments.mass.edit', compact('payment', 'appointments', 'treatments', 'prescriptionsTreatments', 'xrays', 'patients'));
        }
        return abort(403);
    }

    public function editSingle(string $patientId, string $paymentId)
    {
        $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
        $authUserEmail = auth()->user()->email;
        if(in_array($authUserEmail, $allowedUsersEmails)){
            $patient = \App\Models\Patient::findOrFail($patientId);
            $payment = Payment::findOrFail($paymentId);
            $appointments = $patient->appointment()->get();
            $treatments = collect();
            foreach ($appointments as $appointment) {
                $appointmentTreatments = $appointment->treatment()->get();
                $treatments = $treatments->merge($appointmentTreatments);
            }
            $prescriptionsTreatments = collect();
            foreach ($treatments as $treatment) {
                $prescriptionsOfTreatments = $treatment->prescriptionTreatment()->get();
                $prescriptionsTreatments = $prescriptionsTreatments->merge($prescriptionsOfTreatments);
            }
            $xrays = $patient->xray()->get();
        return view('dashboard.payments.single.single-edit' , compact('patient','payment', 'appointments', 'treatments', 'prescriptionsTreatments', 'xrays'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentRequest $request, string $id)
    {
        $payment = Payment::findOrFail($id);
        try {
            $validatedData = $request->validated();
            // Check if any changes have been made to the model's attributes
            $changesDetected = false;
            foreach ($validatedData as $key => $value) {
                if ($payment->{$key} != $value) {
                    $changesDetected = true;
                    break;
                }
            }
            if (!$changesDetected) {
                return redirect()->route('payments.edit', $payment->id)->with('warning', 'No changes were made!');
            }

            // Calculate total amount
            $totalAmount = 0;

            if (isset($validatedData['appointment_id'])) {
                $appointment  = Appointment::find($validatedData['appointment_id']);
                $totalAmount += $appointment->cost;
            }

            if (isset($validatedData['treatment_id'])) {
                $treatment    = Treatment::find($validatedData['treatment_id']);
                $totalAmount += $treatment->cost;
            }

            if (isset($validatedData['prescription_treatment_id'])) {
                $prescriptionTreatment  = PrescriptionTreatment::find($validatedData['prescription_treatment_id']);
                foreach($prescriptionTreatment->treatment->materials as $material){
                    // $materialsTotalCost = $material->pivot->material_quantity * $material->cost;
                    $totalAmount += $material->pivot->material_quantity * $material->cost;
                }
            }

            if (isset($validatedData['xray_id'])) {
                $xray         = XRay::find($validatedData['xray_id']);
                $totalAmount += $xray->cost;
            }

            $totalAmountBeforeDiscount = $totalAmount; // Handling the total amount before the discount (if only there is an existing discount)

            // Apply discount if available
            if (isset($validatedData['discount'])) {
                $totalAmount = $totalAmount - ($totalAmount * ($validatedData['discount'] / 100));
            }

            $appointment = Appointment::find($validatedData['appointment_id']);
            if (!$appointment || $appointment->patient_id != $validatedData['patient_id']) {
                return redirect()->back()->with('error', 'The patient you selected is not the same patient in the "Appointment"!');
            }

            $treatment = Treatment::find($validatedData['treatment_id']);
            if(isset($validatedData['treatment_id'])){
                if (!$treatment || $treatment->appointment->patient_id != $validatedData['patient_id']) {
                    return redirect()->back()->with('error', 'The patient you selected is not the same patient in the "Treatment"!');
                }
            }

            $prescriptionTreatment = PrescriptionTreatment::find($validatedData['prescription_treatment_id']);
            if(isset($validatedData['prescription_treatment_id'])){
                if (!$prescriptionTreatment || $prescriptionTreatment->treatment->appointment->patient_id != $validatedData['patient_id']) {
                    return redirect()->back()->with('error', 'The patient you selected is not the same patient in the "Treatment\'s Prescription"!');
                }
            }

            // Find the X-ray associated with the appointment's patient
            $xray = XRay::find($validatedData['xray_id']);
            if(isset($validatedData['xray_id'])){
                if (!$xray || $xray->patient_id != $validatedData['patient_id']) {
                    return redirect()->back()->with('error', 'The patient you selected is not the same patient in the "X-ray"!');
                }
            }

            $payment->update([
                'payment_method'            => $validatedData['payment_method'] ?? 'cash',
                'discount'                  => $validatedData['discount'],
                'payment_date'              => $validatedData['payment_date'],
                'payment_time'              => $validatedData['payment_time'],
                'appointment_id'            => $validatedData['appointment_id'],
                'treatment_id'              => $validatedData['treatment_id'] ?? null,
                'prescription_treatment_id' => $validatedData['prescription_treatment_id'] ?? null,
                'xray_id'                   => $validatedData['xray_id'] ?? null,
                'patient_id'                => $validatedData['patient_id'],
                'amount_before_discount'    => $totalAmountBeforeDiscount,
                'amount_after_discount'     => $totalAmount
            ]);
            return redirect()->back()->with('success', 'Payment (ID: '.$payment->id.') has been updated successfully for ('.$payment->appointment->patient->first_name .' '. $payment->appointment->patient->last_name.').');
        } catch (\Exception $exception){
            dump($exception);
            return redirect()->route('payments.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        try {
            $payment->delete();
            return redirect()->back()->with('success', 'Payment (ID: '.$payment->id.') has been deleted successfully for ('.$payment->appointment->patient->first_name .' '. $payment->appointment->patient->last_name.').');
        } catch (\Exception $exception) {
            dump($exception);
            return redirect()->route('payments.index')->with('error', 'Something went wrong!');
        }
    }
}
