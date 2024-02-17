@extends('layouts.dashboard.master')
@section('title', "Appointment (ID: $appointment->id)")
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    Add Last Visit For&nbsp;<span class="text-success fw-bold">{{ $appointment->patient->first_name }}</span>?
                    <a href="{{ route('patients.lastVisitsCreate', $appointment->patient->id) }}"><i class="icofont icofont-meeting-add text-success f-60"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Print&nbsp;
                    <a target="_blank" href="{{ route('appointments.show.pdf', $appointment->id) }}"><i class="icofont icofont-printer f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Add X-ray For&nbsp;<span class="text-warning fw-bold">{{ $appointment->patient->first_name }}</span>?
                    <a href="{{ route('patient.x-rays.create', $appointment->patient->id) }}"><i class="icofont icofont-tooth text-warning f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('appointments.edit', $appointment->id) }}">Edit The Current Appointment</a>
            </div>
            <strong class="card-title">
                <p class="fs-5"><span class="text-decoration-underline">Appointment ID:</span> <span class="badge rounded-pill badge-dark">{{ $appointment->id }}</span></p>
                <p class="fs-5"><span class="text-decoration-underline">Patient ID:</span> <span class="badge rounded-pill badge-dark">{{ $appointment->patient->id }}</span></p>
                <p class="fs-5"><span class="text-decoration-underline">Patient Full Name:</span> <span style="background-color: rgb(235, 235, 235);" class="text-dark fw-bold p-1 rounded">{{ $appointment->patient->first_name .' '. $appointment->patient->last_name }}</span></p>
            </strong>
            <div class="d-flex justify-content-center">
                @php $patientImage = $appointment->patient->image; @endphp
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
                            <a class="text-primary fw-bold text-decoration-underline" href="{{ route('appointmentsOfPatient.showIndex', $appointment->patient->id) }}">Click here</a> to see all the <span class="fw-bold">appointments</span> of the current patient.
                        </div>
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5><span class="text-decoration-underline">Diagnosis:</span>
                                    @if($appointment->diagnosis)
                                    {{ $appointment->diagnosis }}
                                    @else
                                    <span class="badge badge-danger">Unsigned</span>
                                    @endif
                                </h5>
                                <p>
                                    <span class="text-decoration-underline">Reason:</span> <span class="text-muted">
                                        @if($appointment->appointment_reason == 'examination')
                                        <span class="badge bg-info fw-bolder f-12">Examination</span>
                                        @else
                                        <span class="badge bg-warning text-dark fw-bolder f-12">Re-examination</span>
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <div class="card-body">
                                <p><span class="text-primary fw-bold text-decoration-underline">Doctor:</span> {{ $appointment->doctor->username }}</p>
                                <p>
                                    <span class="text-decoration-underline">Status:</span>
                                    <span class="
                                    @if($appointment->status == "scheduled") badge badge-info
                                    @elseif($appointment->status == "completed") badge badge-success
                                    @else($appointment->status == "canceled") badge badge-danger
                                    @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </p>
                                <p>
                                    <span class="text-decoration-underline">Date:</span> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $appointment->appointment_date)->format('d-M-Y') }}
                                    <br/>
                                    <span class="text-decoration-underline">Time:</span> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </p>
                                <hr/>
                                <p>
                                    <span class="text-decoration-underline">Cost (EGP):</span> <span class="badge badge-dark text-light">{{ $appointment->cost }}</span>
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
