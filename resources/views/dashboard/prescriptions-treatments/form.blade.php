{{-- <div class="form-group">
    <label for="prescription">Prescription <span class="text-danger">*</span></label>
    <textarea name="prescription" class="form-control border-1 border-dark mb-2 @error('prescription') is-invalid @enderror" id="prescription" placeholder="" cols="30" rows="6">{{ old('prescription', $prescriptionTreatment->prescription) }}</textarea>
    @error('prescription')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div> --}}

<div class="form-group">
    <label for="allergy">Allergy</label>
    <input type="text" name="allergy" class="form-control border-1 border-dark mb-2 @error('allergy') is-invalid @enderror" id="allergy" placeholder="" value="{{old('allergy', $prescriptionTreatment->allergy)}}">
    @error('allergy')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="treatment_id">Treatment <span class="text-danger">*</span> &rightarrow; <span class="text-muted">(Treat. ID: id) - Patient Full Name</span></label>
    <select class="form-control border-1 border-dark @error('treatment_id') is-invalid @enderror" name="treatment_id" id="treatment_id">
        <option value="" selected>-------- Select a treatment --------</option>
        @forelse($treatments as $treatment)
        <option value="{{ $treatment->id }}" {{ $treatment->id == $prescriptionTreatment->treatment_id ? 'selected' : '' }}>({{ $treatment->id }})
            -
            @if($treatment->prescription_id == null)
                {{ $treatment->appointment->patient->first_name . ' ' . $treatment->appointment->patient->last_name }}
            @else
                {{ $treatment->prescription->appointment->patient->first_name . ' ' . $treatment->prescription->appointment->patient->last_name }}
            @endif
        </option>
        @empty
        <option value="">No treatments.</option>
        @endforelse
    </select>
    @error('treatment_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="next_visit">Next Visit <span class="text-muted">(mm-dd-yyyy, hours & seconds)</span></label>
    <input type="datetime-local"name="next_visit" class="form-control border-1 border-dark mb-2 @error('next_visit') is-invalid @enderror" id="next_visit" placeholder="" value="{{old('next_visit', $prescriptionTreatment->next_visit)}}">
    @error('next_visit')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
