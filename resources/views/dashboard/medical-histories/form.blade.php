<div class="form-group">
    <label for="notes">Notes</label>
    <textarea name="notes" class="form-control border-1 border-dark mb-2 @error('notes') is-invalid @enderror" id="notes" placeholder="" cols="30" rows="5">{{ old('notes', $medicalHistory->notes) }}</textarea>
    @error('notes')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="prescription_id_id">Appointment <span class="text-danger">*</label>
    <select class="form-control border-1 border-dark @error('appointment_id') is-invalid @enderror" name="appointment_id" id="appointment_id">
        <option selected>-------- Select an appointment --------</option>
        @forelse($appointments as $appointment)
        <option value="{{ $appointment->id }}" {{ $appointment->id == $medicalHistory->appointment_id ? 'selected' : '' }}>({{ $appointment->id }}) - {{ $medicalHistory->appointment->patient->first_name . ' ' . $medicalHistory->appointment->patient->last_name }}</option>
        @empty
        <option>No appointments.</option>
        @endforelse
    </select>
    @error('appointment_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="prescription_id">Appointment's Prescription <span class="text-danger">*</label>
    <select class="form-control border-1 border-dark @error('prescription_id') is-invalid @enderror" name="prescription_id" id="prescription">
        <option selected>-------- Select an appointment's Prescription --------</option>

        @forelse($prescriptions as $prescription)
        <option value="{{ $prescription->id }}" {{ $prescription->id == $medicalHistory->prescription_id ? 'selected' : '' }}>({{ $prescription->id }}) - {{ $medicalHistory->prescription->appointment->patient->first_name . ' ' . $medicalHistory->prescription->appointment->patient->last_name }}</option>
        @empty
        <option>No Prescriptions.</option>
        @endforelse
    </select>
    @error('prescription')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="treatment_id">Treatment <span class="text-danger">*</label>
    <select class="form-control border-1 border-dark @error('treatment_id') is-invalid @enderror" name="treatment_id" id="prescription">
        <option selected>-------- Select an Treatment  --------</option>

        @forelse($treatments as $treatment)
        <option value="{{ $treatment->id }}" {{ $treatment->id == $medicalHistory->treatment_id ? 'selected' : '' }}>({{ $treatment->id }}) - {{ $medicalHistory->treatment->appointment->patient->first_name . ' ' . $medicalHistory->treatment->appointment->patient->last_name }}</option>
        @empty
        <option>No Treatments.</option>
        @endforelse
    </select>
    @error('treatment')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="prescription_treatment_id"> Treatment's Prescription <span class="text-danger">*</label>
    <select class="form-control border-1 border-dark @error('prescription_treatment_id') is-invalid @enderror" name="prescription_treatment_id" id="prescription">
        <option selected>-------- Select an Treatment's prescription --------</option>

        @forelse($treatments as $treatment)
        <option value="{{ $treatment->id }}" {{ $treatment->id == $medicalHistory->treatment_id ? 'selected' : '' }}>({{ $treatment->id }}) - {{ $medicalHistory->prescriptionTreatment->treatment->appointment->patient->first_name . ' ' . $medicalHistory->prescriptionTreatment->treatment->appointment->patient->last_name }}</option>
        @empty
        <option>No Treatments.</option>
        @endforelse
    </select>
    @error('treatment')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>appointment->
        </span>
    @enderror
</div>
