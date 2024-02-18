@extends('layouts.dashboard.master')
@section('title', "Treatment (ID: $treatment->id)")
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <div class="d-flex justify-content-between">
                @if($treatment->prescription_id != null && $treatment->treatment_id == null)
                    <div class="d-flex align-items-center">
                        Add Last Visit For&nbsp;<span class="text-success fw-bold">{{ $treatment->prescription->appointment->patient->first_name }}</span>?
                        <a href="{{ route('patients.lastVisitsCreate', $treatment->prescription->appointment->patient->id) }}"><i class="icofont icofont-meeting-add text-success f-60"></i><i class="icon-hand-point-up f-16"></i></a>
                    </div>
                    <div class="d-flex align-items-center">
                        Print&nbsp;
                        <a href="{{ route('treatments.show.pdf', $treatment->id) }}"><i class="icofont icofont-printer f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                    </div>
                    <div class="d-flex align-items-center">
                        Add X-ray For&nbsp;<span class="text-warning fw-bold">{{ $treatment->prescription->appointment->patient->first_name }}</span>?
                        <a href="{{ route('patient.x-rays.create', $treatment->prescription->appointment->patient->id) }}"><i class="icofont icofont-tooth text-warning f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                    </div>
                @else($treatment->prescription_id == null && $treatment->treatment_id != null)
                    <div class="d-flex align-items-center">
                        Add Last Visit For&nbsp;<span class="text-success fw-bold">{{ $treatment->appointment->patient->first_name }}</span>?
                        <a href="{{ route('patients.lastVisitsCreate', $treatment->appointment->patient->id) }}"><i class="icofont icofont-meeting-add text-success f-60"></i><i class="icon-hand-point-up f-16"></i></a>
                    </div>
                    <div class="d-flex align-items-center">
                        Print&nbsp;
                        <a href="{{ route('treatments.show.pdf', $treatment->id) }}"><i class="icofont icofont-printer f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                    </div>
                    <div class="d-flex align-items-center">
                        Add X-ray For&nbsp;<span class="text-warning fw-bold">{{ $treatment->appointment->patient->first_name }}</span>?
                        <a href="{{ route('patient.x-rays.create', $treatment->appointment->patient->id) }}"><i class="icofont icofont-tooth text-warning f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                    </div>
                @endif
            </div>
            {{-- <div class="d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('treatments.edit', $treatment->id) }}">Edit The Current Treatment</a>
            </div> --}}
            <strong class="card-title">
                <p class="fs-5"><span class="text-decoration-underline">Treatment ID:</span> <span class="badge rounded-pill badge-dark">{{ $treatment->id }}</span></p>
                @if($treatment->prescription_id != null && $treatment->treatment_id == null)
                    <p class="fs-5"><span class="text-decoration-underline">Patient ID:</span> <span class="badge rounded-pill badge-dark">{{ $treatment->prescription->appointment->patient->id }}</span></p>
                    <p class="fs-5"><span class="text-decoration-underline">Patient Full Name:</span> <span style="background-color: rgb(235, 235, 235);" class="text-dark fw-bold p-1 rounded">{{ $treatment->prescription->appointment->patient->first_name .' '. $treatment->prescription->appointment->patient->last_name }}</span></p>
                @else($treatment->prescription_id == null && $treatment->treatment_id != null)
                    <p class="fs-5"><span class="text-decoration-underline">Patient ID:</span> <span class="badge rounded-pill badge-dark">{{ $treatment->appointment->patient->id }}</span></p>
                    <p class="fs-5"><span class="text-decoration-underline">Patient Full Name:</span> <span style="background-color: rgb(235, 235, 235);" class="text-dark fw-bold p-1 rounded">{{ $treatment->appointment->patient->first_name .' '. $treatment->appointment->patient->last_name }}</span></p>
                @endif
            </strong>
            <div class="d-flex justify-content-center">
                @php $patientImage = $treatment->prescription_id != null && $treatment->treatment_id == null ? $treatment->prescription->appointment->patient->image : $treatment->appointment->patient->image; @endphp
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
                            @if($treatment->prescription_id != null && $treatment->treatment_id == null)
                            <a class="text-primary fw-bold text-decoration-underline" href="{{ route('treatmentsOfPatient.showIndex', $treatment->prescription->appointment->patient->id) }}">Click here</a> to see all the <span class="fw-bold">treatments</span> of the current patient.
                            @else($treatment->prescription_id == null && $treatment->treatment_id != null)
                            <a class="text-primary fw-bold text-decoration-underline" href="{{ route('treatmentsOfPatient.showIndex', $treatment->appointment->patient->id) }}">Click here</a> to see all the <span class="fw-bold">treatments</span> of the current patient.
                            @endif
                        </div>
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5><span class="text-decoration-underline">Procedure Name:</span> {{ $treatment->procedure_name }}</h5>
                                <p>
                                    <span class="text-decoration-underline">Treatment Type:</span> <span class="text-muted">{{ ucfirst($treatment->treatment_type) }}</span>
                                </p>
                            </div>
                            <div class="card-body">
                                <p>
                                    <span class="text-primary fw-bold text-decoration-underline">Doctor:</span>
                                    @if($treatment->prescription_id != null && $treatment->treatment_id == null)
                                        {{ $treatment->prescription->appointment->doctor->username }}
                                    @else($treatment->prescription_id == null && $treatment->treatment_id != null)
                                        {{ $treatment->appointment->doctor->username }}
                                    @endif
                                </p>
                                <p><span class="text-decoration-underline">Status:</span>
                                    <span class="
                                    @if($treatment->status == "scheduled") badge badge-info
                                    @elseif($treatment->status == "completed") badge badge-success
                                    @else($treatment->status == "canceled") badge badge-danger
                                    @endif">
                                        {{ ucfirst($treatment->status) }}
                                    </span>
                                </p>
                                <p>
                                    <span class="text-decoration-underline">Date:</span> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $treatment->treatment_date)->format('d-M-Y') }}
                                    <br/>
                                    <span class="text-decoration-underline">Time:</span> {{ \Carbon\Carbon::parse($treatment->treatment_time)->format('h:i A') }}
                                </p>
                                <p>
                                    <span class="bg-warning rounded-pill p-2 text-dark fw-bold h6">Notes <i class="icofont icofont-arrow-right f-18"></i></span>
                                    @if($treatment->notes != null)
                                    <span>{{ $treatment->notes }}</span>
                                    @else
                                    <span class="text-danger">N/A</span>
                                    @endif
                                </p>
                                <hr/>
                                <p>
                                    <span class="text-decoration-underline">Cost (EGP):</span> <span class="badge badge-dark text-light"> {{$treatment->cost }}</span>
                                </p>
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
