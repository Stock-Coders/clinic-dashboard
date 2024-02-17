<div class="form-group">
    <label for="last_visit_date">Date <span class="text-danger">*</span></label>
    <input type="date" name="last_visit_date" class="form-control border-1 border-dark mb-2 @error('last_visit_date') is-invalid @enderror" id="last_visit_date" placeholder="" value="{{old('last_visit_date', $lastVisit->last_visit_date)}}">
    @error('last_visit_date')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

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

{{-- <div class="form-group">
    <label for="patient_id">Patient <span class="text-danger">*</span></label>
    <select class="form-control border-1 border-dark @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id">
        <option value="" selected>-------- Select a patient --------</option>
        @forelse($patients as $patient)
            <option value="{{ $patient->id }}" {{ $patient->id == $lastVisit->patient_id ? 'selected' : '' }}>
               (ID: {{ $patient->id }}) - {{ $patient->first_name . ' ' . $patient->last_name }}
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
</div> --}}

