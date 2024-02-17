<div class="form-group">
    <label for="medical_lab_name">Medical Lab Name <span class="text-danger">*</span></label>
    <input type="text" name="medical_lab_name" class="form-control border-1 border-dark mb-2 @error('medical_lab_name') is-invalid @enderror" id="medical_lab_name" placeholder="" value="{{$analysis->medical_lab_name ?? ''}}">
    @error('medical_lab_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="analysis_type">Analysis Type <span class="text-danger">*</span></label>
    <input type="text"name="analysis_type" class="form-control border-1 border-dark mb-2 @error('analysis_type') is-invalid @enderror" id="analysis_type" placeholder="" value="{{old('analysis_type', $analysis->analysis_type)}}">
    @error('analysis_type')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="analysis_date">Analysis Date <span class="text-danger">*</span></label>
    <input type="date"name="analysis_date" class="form-control border-1 border-dark mb-2 @error('analysis_date') is-invalid @enderror" id="analysis_date" placeholder="" value="{{old('analysis_date', $analysis->analysis_date)}}">
    @error('analysis_date')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="analysis_time">Analysis Time <span class="text-danger">*</span></label>
    <input type="time"name="analysis_time" class="form-control border-1 border-dark mb-2 @error('analysis_time') is-invalid @enderror" id="analysis_time" placeholder="" value="{{old('analysis_time', $analysis->analysis_time)}}">
    @error('analysis_time')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="recommendations">Recommendations</label>
    <textarea name="recommendations" class="form-control border-1 border-dark mb-2 @error('recommendations') is-invalid @enderror" id="recommendations" placeholder="" cols="30" rows="3">{{ old('recommendations', $analysis->recommendations) }}</textarea>
    @error('recommendations')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea name="notes" class="form-control border-1 border-dark mb-2 @error('notes') is-invalid @enderror" id="notes" placeholder="" cols="30" rows="3">{{ old('notes', $analysis->notes) }}</textarea>
    @error('notes')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="doctor_id">Doctor <span class="text-danger">*</span></label>
    <select class="form-control border-1 border-dark @error('doctor_id') is-invalid @enderror" name="doctor_id" id="doctor_id">
        <option selected>-------- Select a doctor --------</option>
        {{-- @if($doctors->count() > 0)
        <option value="" selected>-------- Select a doctor --------</option>
        @endif --}}
        @forelse($doctors as $doctor)
        <option value="{{ $doctor->id }}" {{ $doctor->id == $analysis->doctor_id ? 'selected' : '' }}>{{ $doctor->username }}</option>
        @empty
        <option>No doctors.</option>
        @endforelse
    </select>
    @error('doctor_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="patient_id">Patient <span class="text-danger">*</span></label>
    <select class="form-control border-1 border-dark @error('patient_id') is-invalid @enderror" name="patient_id" id="patient_id">
        <option selected>-------- Select a patient --------</option>
        {{-- @if($patients->count() > 0)
        <option value="" selected>-------- Select a patient --------</option>
        @endif --}}
        @forelse($patients as $patient)
        <option value="{{ $patient->id }}" {{ $patient->id == $analysis->patient_id ? 'selected' : '' }}>{{ $patient->first_name . ' ' . $patient->last_name }}</option>
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


