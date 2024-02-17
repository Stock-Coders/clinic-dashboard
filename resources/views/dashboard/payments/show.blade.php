@extends('layouts.dashboard.master')

@section('title')
{{ $payment->patient->first_name }}'s Payment (ID: {{ $payment->id }})
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    Add Last Visit For&nbsp;<span class="text-success fw-bold">{{ $payment->patient->first_name }}</span>?
                    <a href="{{ route('patients.lastVisitsCreate', $payment->patient_id) }}"><i class="icofont icofont-meeting-add text-success f-60"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Print&nbsp;
                    <a target="_blank" href="{{ route('receipts.show.pdf', $payment->id) }}"><i class="icofont icofont-printer f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Add X-ray For&nbsp;<span class="text-warning fw-bold">{{ $payment->patient->first_name }}</span>?
                    <a href="{{ route('patient.x-rays.create', $payment->patient_id) }}"><i class="icofont icofont-tooth text-warning f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('payments.edit', $payment->id) }}">Edit The Current Payment</a>
            </div>
            <strong class="card-title">
                <p class="fs-5"><span class="text-decoration-underline">Payment ID:</span> <span class="badge rounded-pill badge-dark">{{ $payment->id }}</span></p>
                <p class="fs-5"><span class="text-decoration-underline">Patient ID:</span> <span class="badge rounded-pill badge-dark">{{ $payment->patient_id }}</span></p>
                <p class="fs-5"><span class="text-decoration-underline">Patient Full Name:</span> <span style="background-color: rgb(235, 235, 235);" class="text-dark fw-bold p-1 rounded">{{ $payment->patient->first_name .' '. $payment->patient->last_name }}</span></p>
            </strong>
            <div class="d-flex justify-content-center">
                @php $patientImage = $payment->patient->image; @endphp
                <img src='{{ asset("/assets/dashboard/images/custom-images/patients/images/$patientImage") }}' alt="Patient Image?" width="200">
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                {{-- Start - Container-fluid --}}
                <div class="container-fluid">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="mb-1">
                            <a class="text-primary fw-bold text-decoration-underline" href="{{ route('patient.payments.index', $payment->patient_id) }}">Click here</a> to see all the <span class="fw-bold">payments</span> of the current patient.
                        </div>
                        <div class="card">
                            <div class="card-header pb-0 mb-3">
                                <p class="h5">
                                    <span class="text-decoration-underline">Payment Method:</span>
                                    <span class="text-muted">
                                        @if($payment->payment_method == 'vodafone_cash')
                                            Vodafone Cash
                                        @elseif($payment->payment_method == 'credit_card')
                                            Credit Card
                                        @else
                                            {{ ucfirst($payment->payment_method) }}
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <div class="card-body p-0">
                                {{-- <p><span class="text-primary fw-bold text-decoration-underline">Doctor:</span> {{ $payment->appointment->doctor->username }}</p> --}}
                                <p class="px-5">
                                    <span class="text-decoration-underline">Appointment (<span class="fw-bold">ID</span>):</span>
                                    <a class="fw-bold" href="{{ route('appointments.show', $payment->appointment_id) }}">
                                        {{ $payment->appointment_id }}{{ '- '.$payment->appointment->diagnosis }}
                                    </a>
                                    <br/>
                                    <span class="text-decoration-underline">Treatment (<span class="fw-bold">ID</span>):</span>
                                    @if($payment->treatment_id)
                                    <a class="fw-bold" href="{{ route('treatments.show', $payment->treatment_id) }}">
                                        {{ $payment->treatment_id }}{{ '- '.$payment->treatment->procedure_name }}
                                    </a>
                                    @else
                                    —
                                    @endif
                                    <br/>
                                    <span class="text-decoration-underline">Treatment's Prescription (<span class="fw-bold">ID</span>):</span>
                                    @if($payment->prescription_treatment_id)
                                    <a class="fw-bold" href="{{ route('prescriptions-treatments.show', $payment->prescription_treatment_id) }}">
                                        {{ $payment->prescription_treatment_id ?? '—' }}
                                    </a>
                                    @else
                                    —
                                    @endif
                                    <br/>
                                    <span class="text-decoration-underline">X-ray(s) (<span class="fw-bold">ID</span>):</span>
                                    @if($payment->xrays)
                                        @foreach($payment->xrays as $key => $xray)
                                            <a href="{{ route('x-rays.show', $xray->id) }}" class="text-decoration-none">
                                                <span class="badge rounded-circle badge-primary"><span class="fw-bold">{{ $xray->id }}</span></span>
                                            </a>
                                            <span class="text-danger fw-bold">{{ $key < $payment->xrays->count() - 1 ? '-' : '' }}</span>
                                        @endforeach
                                    @else
                                    —
                                    @endif
                                </p>
                                <p class="px-5">
                                    <span class="text-decoration-underline">Date:</span> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $payment->payment_date)->format('d-M-Y') }}
                                    <br/>
                                    <span class="text-decoration-underline">Time:</span> {{ \Carbon\Carbon::parse($payment->payment_time)->format('h:i A') }}
                                </p>
                                <hr/>
                                <div class="d-flex justify-content-center p-4">
                                    <div class="alert alert-info w-100" style="background-color: rgb(247, 242, 207); color:rgb(207, 186, 25);">
                                        <span>The "<span class="text-decoration-underline fw-bold">Total Cost</span>" will be the sum of the costs of all the following if they are avaiable:</span>
                                        <br/>
                                        <ul style="list-style-type:disc;" class="py-1 px-4">
                                            <li>Appointment (<span class="fw-bold">Required</span>)</li>
                                            <li>Treatment (<span class="fw-bold">Optional</span>)</li>
                                            <li>Treatment's Prescription (<span class="fw-bold">Optional</span>)</li>
                                            <li>X-ray(s) (<span class="fw-bold">Optional</span>)</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-evenly">
                                    <p>
                                        <span class="text-decoration-underline">Discount (%):</span>
                                        @if($payment->discount == null || $payment->discount == 0)
                                            <span class="badge badge-info text-center f-14">0%</span>
                                        @elseif($payment->discount != null && $payment->discount >= 1)
                                            <span class="badge badge-warning text-center text-dark f-14">{{ $payment->discount }}%</span>
                                        @endif
                                    </p>
                                    <p>
                                        <span class="text-decoration-underline">Total Cost (EGP):</span>
                                        @if($payment->discount != null && $payment->discount >= 1)
                                            <del class="text-danger fw-bold">{{ $payment->amount_before_discount }}</del>
                                            &rightarrow;
                                            <span class="badge badge-success text-center text-light fs-6">{{ $payment->amount_after_discount }}</span>
                                        @elseif($payment->discount == null || $payment->discount == 0)
                                            <span class="badge badge-dark text-center text-light fs-6">{{ $payment->amount_after_discount }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                {{-- End - Container-fluid --}}
              </div> <!-- /.col -->
            </div>
          </div>
        </div> <!-- / .card -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
@endsection
