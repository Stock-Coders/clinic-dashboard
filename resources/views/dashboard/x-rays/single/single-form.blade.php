@include('dashboard.x-rays.common-form')

{{-- Single create for patient's x-ray is accessed by the patient id itself --}}
@if(Route::is('patient.x-rays.create', $patient->id))
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
{{-- Single edit for patient's x-ray is accessed by the x-ray and then pointing on the patient --}}
@else(Route::is('patient.x-rays.edit', $xray->patient->id))
<div class="form-group">
    <label for="patient_id">Patient <span class="text-danger">*</span></label>
    <select class="form-control border-1 border-dark @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id">
        <option value="{{ $xray->patient->id }}" selected>{{ $xray->patient->first_name . ' ' . $xray->patient->last_name }}</option>
    </select>
    @error('patient_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@endif
