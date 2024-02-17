@include('dashboard.payments.common-form')

{{-- <div class="form-group">
    <label for="patient_id">Patient <span class="text-danger">*</span></label>
    <select class="form-control border-1 border-dark @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id">
        <option value="{{ $patient->id }}" selected>{{ $patient->first_name . ' ' . $patient->last_name }}</option>
    </select>
    @error('patient_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div> --}}

{{-- Single create for patient's payment is accessed by the patient id itself --}}
@if(Route::is('patient.payments.create', $patient->id))
<div class="form-group">
    <label for="patient_id">Patient <span class="text-danger">*</span></label>
    <select class="form-control border-1 border-dark @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id">
        <option value="{{ $patient->id }}" selected>{{ $patient->first_name . ' ' . $patient->last_name }}</option>
    </select>
    @error('patient_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
{{-- Single edit for patient's payment is accessed by the payment and then pointing on the patient --}}
@else(Route::is('patient.payments.edit', $payment->patient->id))
<div class="form-group">
    <label for="patient_id">Patient <span class="text-danger">*</span></label>
    <select class="form-control border-1 border-dark @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id">
        <option value="{{ $payment->patient->id }}" selected>{{ $payment->patient->first_name . ' ' . $payment->patient->last_name }}</option>
    </select>
    @error('patient_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@endif
