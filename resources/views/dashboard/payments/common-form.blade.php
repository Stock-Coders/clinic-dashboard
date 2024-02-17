<div class="form-group">
    <label>Discount (%)</label>
    <select name="discount" class="form-control select discount border-1 border-dark @error('discount') is-invalid @enderror" id="discount">
        {{-- <option value="">---------- Select a discount ----------</option> --}}
        @for($d = 0; $d <= 100; $d += 1)
            <option value="{{ $d }}" {{ $payment->discount == $d ? 'selected' : '' }}>
                @if($d == 0)
                    {{ $d }}% (No Discount) <!-- equals to 0% -->
                @else
                    {{ $d }}%  <!-- bigger than 0% -->
                @endif
            </option>
        @endfor
    </select>
    @error('discount')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

{{-- <div class="form-group">
    <label for="discount">Discount (%)</label>
    <input type="number" min="0" name="discount" class="form-control border-1 border-dark mb-2 @error('discount') is-invalid @enderror" id="discount" placeholder="" value="{{old('discount', $payment->discount)}}">
    @error('discount')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div> --}}

<div class="form-group">
    <label for="payment_method">Payment Method <span class="text-muted">(If not selected, then "Cash" by default)</span></label>
    <select class="form-control select border-1 border-dark mb-2 @error('payment_method') is-invalid @enderror" name="payment_method" id="payment_method">
        <option value="" selected>-------- Select a payment method --------</option>
        <option value="cash" {{$payment->payment_method == "cash" ? 'selected' : ''}}>Cash</option>
        <option value="vodafone_cash" {{$payment->payment_method == "vodafone_cash" ? 'selected' : ''}}>Vodafone Cash</option>
        <option value="credit_card" {{$payment->payment_method == "credit_card" ? 'selected' : ''}}>Credit Card</option>
    </select>
    @error('payment_method')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label for="payment_date">Date <span class="text-danger">*</span></label>
            <input type="date"name="payment_date" class="form-control border-1 border-dark mb-2 @error('payment_date') is-invalid @enderror" id="payment_date" placeholder="" value="{{old('payment_date', $payment->payment_date)}}">
            @error('payment_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label for="payment_time">Time <span class="text-danger">*</span></label>
            <input type="time"name="payment_time" class="form-control border-1 border-dark mb-2 @error('payment_time') is-invalid @enderror" id="payment_time" placeholder="" value="{{old('payment_time', $payment->payment_time)}}">
            @error('payment_time')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label for="appointment_id">Appointment <span class="text-danger">*</span> &rightarrow; <span class="text-muted">(Appoin. ID: id) - Patient Full Name</span></label>
            <select class="form-control border-1 border-dark @error('appointment_id') is-invalid @enderror" name="appointment_id" id="appointment_id">
                <option selected>-------- Select an appointment --------</option>
                @forelse($appointments as $appointment)
                <option value="{{ $appointment->id }}" {{ $appointment->id == $payment->appointment_id ? 'selected' : '' }}>({{ $appointment->id }}) - {{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name }}</option>
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
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        {{-- <div class="form-group">
            <label for="xray_id">X-ray &rightarrow; <span class="text-muted">(X-ray ID: id) - Patient Full Name</span></label>
            <select class="form-control border-1 border-dark @error('xray_id') is-invalid @enderror" name="xray_id" id="xray_id">
                <option value="" selected>-------- Select an X-ray --------</option>
                @forelse($xrays as $xray)
                <option value="{{ $xray->id }}" {{ $xray->id == $payment->xray_id ? 'selected' : '' }}>({{ $xray->id }}) - {{ $xray->patient->first_name . ' ' . $xray->patient->last_name }}</option>
                @empty
                <option value="">No X-rays.</option>
                @endforelse
            </select>
            @error('xray_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div> --}}

        <div class="form-group">
            <label for="xray_id">X-ray &rightarrow; <span class="text-muted">(X-ray ID: id) - Patient Full Name</span></label>
            <br>
            <span class="text-muted">You can select one or more X-ray at the same time.</span>
            <select name="xray_id[]" id="xray_id" class="form-control border-1 border-dark @error('xray_id') is-invalid @enderror" multiple>
                @forelse($xrays as $xray)
                    @php
                        $isSelected = false;
                        if(old('xray_id')) {
                            $isSelected = in_array($xray->id, old('xray_id'));
                        } else {
                            // Check if current X-ray ID is in the array of selected X-rays
                            $isSelected = in_array($xray->id, $selectedXrayIds ?? []);
                        }
                    @endphp
                    {{-- In the patient's single payment creation: Check if the X-ray ID is not present in the array of selected X-ray IDs (if present then hide it, if it was associated before with a payment before) --}}
                    @if(Route::is('patient.payments.create', $payment->patient_id))
                        @if(!in_array($xray->id, $selectedXrayIds ?? []))
                            <option value="{{ $xray->id }}" {{ $isSelected ? 'selected' : '' }}>
                                ({{ $xray->id }}) - {{ $xray->patient->first_name . ' ' . $xray->patient->last_name }}
                            </option>
                        @endif
                    {{-- Everywhere else: Show all the X-rays in general --}}
                    @else
                        <option value="{{ $xray->id }}" {{ $isSelected ? 'selected' : '' }}>
                            ({{ $xray->id }}) - {{ $xray->patient->first_name . ' ' . $xray->patient->last_name }}
                        </option>
                    @endif
                @empty
                    <option value="">No X-rays.</option>
                @endforelse
            </select>
            @error('xray_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label for="treatment_id">Treatment &rightarrow; <span class="text-muted">(Treat. ID: id) - Patient Full Name</span></label>
            <select class="form-control border-1 border-dark @error('treatment_id') is-invalid @enderror" name="treatment_id" id="treatment_id">
                <option value="" selected>-------- Select a treatment --------</option>
                @forelse($treatments as $treatment)
                <option value="{{ $treatment->id }}" {{ $treatment->id == $payment->treatment_id ? 'selected' : '' }}>({{ $treatment->id }}) - {{ $treatment->appointment->patient->first_name . ' ' . $treatment->appointment->patient->last_name }}</option>
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
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label for="prescription_treatment_id">Treatment's Prescription &rightarrow; <span class="text-muted">(Treat. Presc's ID: id) - Patient Full Name</span></label>
            <select class="form-control border-1 border-dark @error('prescription_treatment_id') is-invalid @enderror" name="prescription_treatment_id" id="prescription_treatment_id">
                <option value="" selected>-------- Select a treatment's prescription --------</option>
                @forelse($prescriptionsTreatments as $prescriptionTreatment)
                <option value="{{ $prescriptionTreatment->id }}" {{ $prescriptionTreatment->id == $payment->prescription_treatment_id ? 'selected' : '' }}>({{ $prescriptionTreatment->id }}) - {{ $prescriptionTreatment->treatment->appointment->patient->first_name . ' ' . $prescriptionTreatment->treatment->appointment->patient->last_name }}</option>
                @empty
                <option value="">No treatments' prescriptions.</option>
                @endforelse
            </select>
            @error('prescription_treatment_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
