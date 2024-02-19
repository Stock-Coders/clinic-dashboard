<div class="form-group">
    <label class="col-sm-4 ">Appointment Reason<span class="text-danger">*</span></label>
    <div class="col-sm-9">
        <div class="d-flex col-md-12 justify-content-start rounded">
            <div>
                <input type="radio" class="@error('appointment_reason') is-invalid @enderror" name="appointment_reason" value="examination" {{ $appointment->appointment_reason == "examination" ? 'checked' : '' }}>
                <label class="mb-0">Examination</label>
            </div>
            <div class="px-5">
                <input type="radio" class="@error('appointment_reason') is-invalid @enderror" name="appointment_reason" value="reexamination" {{$appointment->appointment_reason == "reexamination" ? 'checked' : '' }}>
                <label class="mb-0">Re-examination</label>
            </div>
        </div>
        @error('appointment_reason')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

@if (auth()->user()->user_type == 'doctor' || auth()->user()->user_type == 'developer')
<div class="form-group">
    <label for="diagnosis">Diagnosis
        @if(auth()->user()->user_type == 'doctor')
            <span class="text-danger">*</span>
        @else(auth()->user()->user_type == 'developer')
            <span class="text-muted">(The associated <span class="text-decoration-underline">doctor</span> will receive a notification, if there is o value.)</span>
        @endif
    </label>
    <input type="text" name="diagnosis" class="form-control border-1 border-dark mb-2 @error('diagnosis') is-invalid @enderror" id="diagnosis" placeholder="" value="{{$appointment->diagnosis ?? ''}}">
    @error('diagnosis')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@endif

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control select border-1 border-dark mb-2 @error('status') is-invalid @enderror" name="status" id="status">
                <option value="" selected>-------- Select a status --------</option>
                <option value="scheduled" {{$appointment->status == "scheduled" ? 'selected' : ''}}>Scheduled</option>
                <option value="completed" {{$appointment->status == "completed" ? 'selected' : ''}}>Completed</option>
                <option value="canceled" {{$appointment->status == "canceled" ? 'selected' : ''}}>Canceled</option>
            </select>
            @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label for="cost">Cost (EGP) <span class="text-danger">*</span></label>
            <input type="number" name="cost" class="form-control border-1 border-dark mb-2 @error('cost') is-invalid @enderror" id="cost" value="{{old('cost', $appointment->cost)}}">
            @error('cost')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="appointment_date">Date <span class="text-danger">*</span></label>
    <input type="date"name="appointment_date" class="form-control border-1 border-dark mb-2 @error('appointment_date') is-invalid @enderror" id="appointment_date" placeholder="" value="{{old('appointment_date', $appointment->appointment_date)}}">
    @error('appointment_date')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="appointment_time">Time <span class="text-danger">*</span></label>
    <input type="time"name="appointment_time" class="form-control border-1 border-dark mb-2 @error('appointment_time') is-invalid @enderror" id="appointment_time" placeholder="" value="{{old('appointment_time', $appointment->appointment_time)}}">
    @error('appointment_time')
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
        <option value="{{ $doctor->id }}" {{ $doctor->id == $appointment->doctor_id ? 'selected' : '' }}>{{ $doctor->username }}</option>
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
        <option value="{{ $patient->id }}" {{ $patient->id == $appointment->patient_id ? 'selected' : '' }}>(ID: {{ $patient->id }}) {{ $patient->first_name . ' ' . $patient->last_name }}</option>
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


