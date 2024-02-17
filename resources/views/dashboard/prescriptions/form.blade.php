<div class="form-group">
    <label for="prescription">Prescription <span class="text-danger">*</span></label>
    <textarea name="prescription" class="form-control border-1 border-dark mb-2 @error('prescription') is-invalid @enderror" id="prescription" placeholder="" cols="30" rows="6">{{ old('prescription', $prescription->prescription) }}</textarea>
    @error('prescription')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="allergy">Allergy</label>
    <input type="text" name="allergy" class="form-control border-1 border-dark mb-2 @error('allergy') is-invalid @enderror" id="allergy" placeholder="" value="{{old('allergy', $prescription->allergy)}}">
    @error('allergy')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="appointment_id">Appointment <span class="text-danger">*</span> &rightarrow; <span class="text-muted">(Appoin. ID: id) - Patient Full Name</span></label>
    <select class="form-control border-1 border-dark @error('appointment_id') is-invalid @enderror" name="appointment_id" id="appointment_id">
        <option selected>-------- Select an appointment --------</option>
        {{-- @if($appointments->count() > 0)
        <option value="" selected>-------- Select an appointment --------</option>
        @endif --}}
        @forelse($appointments as $appointment)
        <option value="{{ $appointment->id }}" {{ $appointment->id == $prescription->appointment_id ? 'selected' : '' }}>({{ $appointment->id }}) - {{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name }}</option>
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
    <label for="next_visit">Next Visit <span class="text-muted">(mm-dd-yyyy, hours & seconds)</span></label>
    <input type="datetime-local"name="next_visit" class="form-control border-1 border-dark mb-2 @error('next_visit') is-invalid @enderror" id="next_visit" placeholder="" value="{{old('next_visit', $prescription->next_visit)}}">
    @error('next_visit')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#prescription').summernote();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-bs4.min.js"></script>
@endpush