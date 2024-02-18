<div class="form-group">
    <label for="procedure_name">Procedure Name <span class="text-danger">*</span></label>
    <input type="text" name="procedure_name" class="form-control border-1 border-dark mb-2 @error('procedure_name') is-invalid @enderror" id="procedure_name" placeholder="" value="{{old('procedure_name', $treatment->procedure_name)}}">
    @error('procedure_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


<div class="form-group">
    <label for="treatment_type">Treatment Type <span class="text-danger">*</span></label>
    <select class="form-control select border-1 border-dark mb-2 @error('treatment_type') is-invalid @enderror" name="treatment_type" id="treatment_type">
        <option value="" selected>-------- Select a treatment type --------</option>
        <option value="surgical" {{$treatment->treatment_type == "surgical" ? 'selected' : ''}}>Surgical</option>
        <option value="medical" {{$treatment->treatment_type == "medical" ? 'selected' : ''}}>Medical</option>
        <option value="preventive" {{$treatment->treatment_type == "preventive" ? 'selected' : ''}}>Preventive</option>
    </select>
    @error('treatment_type')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control select border-1 border-dark mb-2 @error('status') is-invalid @enderror" name="status" id="status">
                <option value="" selected>-------- Select a status --------</option>
                <option value="scheduled" {{$treatment->status == "scheduled" ? 'selected' : ''}}>Scheduled</option>
                <option value="completed" {{$treatment->status == "completed" ? 'selected' : ''}}>Completed</option>
                <option value="canceled" {{$treatment->status == "canceled" ? 'selected' : ''}}>Canceled</option>
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
            <input type="number" name="cost" class="form-control border-1 border-dark mb-2 @error('cost') is-invalid @enderror" id="cost" value="{{old('cost', $treatment->cost)}}">
            @error('cost')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="treatment_date">Date <span class="text-danger">*</span></label>
    <input type="date"name="treatment_date" class="form-control border-1 border-dark mb-2 @error('treatment_date') is-invalid @enderror" id="treatment_date" placeholder="" value="{{old('treatment_date', $treatment->treatment_date)}}">
    @error('treatment_date')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="treatment_time">Time <span class="text-danger">*</span></label>
    <input type="time"name="treatment_time" class="form-control border-1 border-dark mb-2 @error('treatment_time') is-invalid @enderror" id="treatment_time" placeholder="" value="{{old('treatment_time', $treatment->treatment_time)}}">
    @error('treatment_time')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

{{-- <div class="form-group">
    <label for="materials">Materials <span class="text-danger">*</span></label>
    @foreach($materials as $material)
        <div class="mb-3">
            <label for="material{{ $material->id }}">{{ $material->title }}</label>
            <input type="number" name="materials[{{ $material->id }}]" id="material{{ $material->id }}" class="form-control" placeholder="Quantity" min="1" value="{{ old('materials.' . $material->id) }}">
        </div>
    @endforeach
    @error('materials')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div> --}}

<div class="form-group">
    <label for="materials">Materials <span class="text-danger">*</span></label>
    <div class="row">
        @foreach($materials->chunk(3) as $chunk)
            <div class="col-md-4">
                @foreach($chunk as $material)
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="materials[{{ $material->id }}]"
                               id="material{{ $material->id }}" value="{{ $material->id }}"
                               class="form-check-input material-checkbox"
                               {{ old('materials.'.$material->id) ? 'checked' : '' }}>
                        <label for="material{{ $material->id }}" class="form-check-label"><span class="fw-bold">{{ $material->title }}</span> (<span class="text-primary fw-bold">{{ $material->cost }} EGP/Unit</span>)</label>
                        <input type="number"
                               name="quantities[{{ $material->id }}]"
                               id="quantity{{ $material->id }}"
                               class="form-control quantity-input {{ old('materials.'.$material->id) ? '' : 'd-none' }}"
                               min="1"
                               placeholder="Quantity"
                               value="{{ old('quantities.'.$material->id) }}">
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    @error('materials')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // for toggling the quantity input hide/show for each checkbox when being checked or unchecked
        const materialCheckboxes = document.querySelectorAll('.material-checkbox');
        materialCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const quantityInput = this.parentElement.querySelector('.quantity-input');
                quantityInput.classList.toggle('d-none', !this.checked);
            });
        });

        // to accept at least one checkbox
        const form = document.querySelector('#alert-form');
        form.addEventListener('submit', function(event) {
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            let atLeastOneChecked = false;

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    atLeastOneChecked = true;
                }
            });

            if (!atLeastOneChecked) {
                event.preventDefault(); // Prevent form submission
                // alert('Please check at least one material.'); // Display an error message
                const msg = 'Please check at least one material.';
                Swal.fire({
                    title: 'Warning!',
                    text: msg,
                    icon: 'info'
                });
            }
        });
    });
</script>

@endpush

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea name="notes" class="form-control border-1 border-dark mb-2 @error('notes') is-invalid @enderror" id="notes" placeholder="" cols="30" rows="3">{{ old('notes', $treatment->notes) }}</textarea>
    @error('notes')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group d-none @if($treatment->prescription_id != null && $treatment->appointment_id == null) d-none @endif">
    <div class="alert alert-info text-light h6">
        <i class="icofont icofont-arrow-down fs-1"></i><i class="fa fa-warning fs-2 text-warning"></i> Choose either the "<span class="text-decoration-underline fw-bold">Prescription</span>" or "<span class="text-decoration-underline fw-bold">Appointment</span>", <span class="text-light fw-bold">not both!</span>
    </div>
</div>

<div class="form-group d-none">
    <label for="prescription_id">Prescription &rightarrow; <span class="text-muted">(Prescr. ID: id) - Patient Full Name</span></label>
    <select class="form-control border-1 border-dark @error('prescription_id') is-invalid @enderror" name="prescription_id" id="prescription_id">
        <option value="" selected>-------- Select a prescription --------</option>
        @forelse($prescriptions as $prescription)
        <option value="{{ $prescription->id }}" {{ $prescription->id == $treatment->prescription_id ? 'selected' : '' }}>({{ $prescription->id }}) - {{ $prescription->appointment->patient->first_name . ' ' . $prescription->appointment->patient->last_name }}</option>

        @empty
        <option value="">No prescriptions.</option>
        @endforelse
    </select>
    @error('prescription_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="appointment_id">Appointment &rightarrow; <span class="text-muted">(Appoin. ID: id) - Patient Full Name</span></label>
    @if(($treatment->appointment_id != null && $treatment->prescription_id == null) || Route::is('treatments.create')) <!-- If the appoitment directly inserted in the treatment -->
        <select class="form-control border-1 border-dark @error('appointment_id') is-invalid @enderror" name="appointment_id" id="appointment_id">
            <option value="" selected>-------- Select an appointment --------</option>
            @forelse($appointments as $appointment)
            <option value="{{ $appointment->id }}" {{ $appointment->id == $treatment->appointment_id ? 'selected' : '' }}>
                ({{ $appointment->id }}) - {{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name }}</option>
            @empty
            <option value="">No appointments.</option>
            @endforelse
        </select>
        @error('appointment_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
         @enderror
    {{-- @else($appointment->appointment_id == null && $appointment->prescription_id != null) <!-- If the appoitment is indirectly inserted in the treatment through the prescription -->
        <select class="form-control border-1 border-dark">
            <option value="{{ $appointment->prescription->appointment_id }}" selected disabled>
                ({{ $appointment->prescription->appointment_id }}) - {{ $appointment->prescription->appointment->patient->first_name . ' ' . $appointment->prescription->appointment->patient->last_name }}
            </option>
        </select>
        <input class="form-control border-1 border-dark mb-2" placeholder="" value="{{ '('. $treatment->prescription->appointment_id . ') - ' .  $treatment->prescription->appointment->patient->first_name . ' ' . $treatment->prescription->appointment->patient->last_name }}" disabled readonly> --}}
    @endif
</div>
<<<<<<< HEAD

{{-- {{ dd(old('treatment_id')) }} --}}
=======
>>>>>>> e481b7231257c384bac5474727534c1dc7b3bf67
