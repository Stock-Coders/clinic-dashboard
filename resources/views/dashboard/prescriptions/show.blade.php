@extends('layouts.dashboard.master')
@section('title', "Prescription (ID: $prescription->id)")
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <div class="mb-4 text-center">
                <h1 class="text-decoration-underline">Patient's Appointment's Prescription</h1>
            </div>
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    Add Last Visit For&nbsp;<span class="text-success fw-bold">{{ $prescription->appointment->patient->first_name }}</span>?
                    <a href="{{ route('patients.lastVisitsCreate', $prescription->appointment->patient->id) }}"><i class="icofont icofont-meeting-add text-success f-60"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Print&nbsp;
                    <a target="_blank" href="{{ route('prescriptions.show.pdf', $prescription->id) }}"><i class="icofont icofont-printer f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Add X-ray For&nbsp;<span class="text-warning fw-bold">{{ $prescription->appointment->patient->first_name }}</span>?
                    <a href="{{ route('patient.x-rays.create', $prescription->appointment->patient->id) }}"><i class="icofont icofont-tooth text-warning f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('prescriptions.edit', $prescription->id) }}">Edit The Current Prescription</a>
            </div>
            <strong class="card-title">
                <p class="fs-6"><span class="text-decoration-underline">Appointment's Prescription ID:</span> <span class="badge rounded-pill badge-dark">{{ $prescription->id }}</span></p>
                <p class="fs-6"><span class="text-decoration-underline">Patient ID:</span> <span class="badge rounded-pill badge-dark">{{ $prescription->appointment->patient->id }}</span></p>
                <p class="fs-6"><span class="text-decoration-underline">Patient Full Name:</span> <span style="background-color: rgb(235, 235, 235);" class="text-dark fw-bold p-1 rounded">{{ $prescription->appointment->patient->first_name .' '. $prescription->appointment->patient->last_name }}</span></p>
            </strong>
            <div class="d-flex justify-content-center">
                @php $patientImage = $prescription->appointment->patient->image; @endphp
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
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5><span class="text-decoration-underline">Prescription:</span>
                                            {!! $prescription->prescription !!}
                                        </h5>
                                    </div>
                                    <div>
                                        <p class="fs-6"><span class="text-decoration-underline fw-bold">Created at:</span> {{ optional($prescription->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</p>
                                        <p class="fs-6"><span class="text-decoration-underline fw-bold">Updated at:</span> {{ $prescription->updated_at ? optional($prescription->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—'}}</p>
                                        <p class="fs-6"><span class="fw-bold text-decoration-underline">Next Visit:</span>
                                            {{ $prescription->next_visit != null ? \Carbon\Carbon::parse($prescription->next_visit)->format('d-M-Y, h:i A') : '—' }}
                                        </p>
                                    </div>
                                </div>
                                <p class="fs-6">
                                    <span class="text-decoration-underline">Allergy:</span>
                                    <span class="
                                    @if($prescription->allergy != null) badge badge-warning text-dark
                                        @endif">
                                        {{ $prescription->allergy ?? '—'}}
                                    </span>
                                </p>
                            </div>
                            <div class="card-body">
                                <p class="fs-6"><span class="text-primary fw-bold text-decoration-underline">Doctor :</span> {{ $prescription->appointment->doctor->profile->name ?? $prescription->appointment->doctor->username }}</p>
                                <p class="fs-6"><span class="fw-bold text-decoration-underline">Appointment ID:</span> <span class="badge rounded-pill badge-dark">{{ $prescription->appointment_id }}</span></p>
                                <p class="fs-6">
                                    <span class="text-primary fw-bold text-decoration-underline ">Appointment Status:</span>
                                    <span class="
                                    @if($prescription->appointment->status == "scheduled") badge badge-primary
                                    @elseif($prescription->appointment->status == "completed") badge badge-success
                                    @else($prescription->status == "canceled") badge badge-danger
                                    @endif">
                                    {{ ucfirst($prescription->appointment->status) }}
                                    </span>
                                </p>
                                <hr/>
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
