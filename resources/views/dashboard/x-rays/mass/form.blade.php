@include('dashboard.x-rays.common-form')

<div class="form-group">
    <label for="patient_id">Patient <span class="text-danger">*</span></label>
    <select class="form-control border-1 border-dark @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id">
        <option value="" selected>-------- Select a patient --------</option>
        @forelse($patients as $patient)
            <option value="{{ $patient->id }}" {{ $patient->id == $xray->patient_id ? 'selected' : '' }}>
                (ID: {{ $patient->id }}) {{ $patient->first_name . ' ' . $patient->last_name }}
            </option>
        @empty
            <option value="">No patients.</option>
        @endforelse
    </select>
    @error('patient_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
