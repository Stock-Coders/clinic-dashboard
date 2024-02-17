@include('dashboard.payments.common-form')

<div class="form-group">
    <label for="patient_id">Patient <span class="text-danger">*</span> &rightarrow; <span class="text-muted">(Patient ID: id) - Patient Full Name</span></label>
    <select class="form-control border-1 border-dark @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id">
        <option selected>-------- Select a patient --------</option>
        @forelse($patients as $patient)
        <option value="{{ $patient->id }}" {{ $patient->id == $payment->patient_id ? 'selected' : '' }}>({{ $patient->id }}) - {{ $patient->first_name . ' ' . $patient->last_name }}</option>
        @empty
        <option>No patients.</option>
        @endforelse
    </select>
    @error('patient_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
