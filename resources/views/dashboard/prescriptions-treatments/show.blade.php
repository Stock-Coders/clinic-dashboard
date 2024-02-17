@extends('layouts.dashboard.master')
@section('title', "Prescription (ID: $prescriptionTreatment->id)")
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <div class="mb-4 text-center">
                <h1 class="text-decoration-underline">Patient's Treatment's Prescription</h1>
            </div>
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    Add Last Visit For&nbsp;<span class="text-success fw-bold">{{ $prescriptionTreatment->treatment->appointment->patient->first_name }}</span>?
                    <a href="{{ route('patients.lastVisitsCreate', $prescriptionTreatment->treatment->appointment->patient->id) }}"><i class="icofont icofont-meeting-add text-success f-60"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Print&nbsp;
                    <a target="_blank" href="{{ route('prescriptions-treatments.show.pdf', $prescriptionTreatment->id) }}"><i class="icofont icofont-printer f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Add X-ray For&nbsp;<span class="text-warning fw-bold">{{ $prescriptionTreatment->treatment->appointment->patient->first_name }}</span>?
                    <a href="{{ route('patient.x-rays.create', $prescriptionTreatment->treatment->appointment->patient->id) }}"><i class="icofont icofont-tooth text-warning f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('prescriptions-treatments.edit', $prescriptionTreatment->id) }}">Edit The Current Treatment's Prescription</a>
            </div>
            <strong class="card-title">
                <p class="fs-6"><span class="text-decoration-underline">Treatment's Prescription ID:</span> <span class="badge rounded-pill badge-dark">{{ $prescriptionTreatment->id }}</span></p>
                <p class="fs-6"><span class="text-decoration-underline">Patient ID:</span> <span class="badge rounded-pill badge-dark">{{ $prescriptionTreatment->treatment->appointment->patient->id }}</span></p>
                <p class="fs-6"><span class="text-decoration-underline">Patient Full Name:</span> <span style="background-color: rgb(235, 235, 235);" class="text-dark fw-bold p-1 rounded">{{ $prescriptionTreatment->treatment->appointment->patient->first_name .' '. $prescriptionTreatment->treatment->appointment->patient->last_name }}</span></p>
            </strong>
            <div class="d-flex justify-content-center">
                @php $patientImage = $prescriptionTreatment->treatment->appointment->patient->image; @endphp
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
                                    <div class="mb-3">
                                        <p>
                                            <span class="text-decoration-underline fw-bold h5">Materials ({{ $prescriptionTreatment->treatment->materials->count() }}):</span>
                                            {{-- {!! $prescriptionTreatment->prescription !!} --}}
                                            <span class="fs-6">
                                                <ul style="list-style-type:disc;">
                                                    @foreach ($prescriptionTreatment->treatment->materials as $material)
                                                        <li>{{ $material->title }} (<span class="fw-bold">{{ $material->pivot->material_quantity }}</span>)</li>
                                                    @endforeach
                                                </ul>
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="fs-6"><span class="text-decoration-underline fw-bold">Created at:</span> {{ optional($prescriptionTreatment->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</p>
                                        <p class="fs-6"><span class="text-decoration-underline fw-bold">Updated at:</span> {{ $prescriptionTreatment->updated_at ? optional($prescriptionTreatment->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—'}}</p>
                                        <p class="fs-6"><span class="fw-bold text-decoration-underline">Next Visit:</span>
                                            {{ $prescriptionTreatment->next_visit != null ? \Carbon\Carbon::parse($prescriptionTreatment->next_visit)->format('d-M-Y, h:i A') : '—' }}
                                        </p>
                                    </div>
                                </div>
                                <p class="fs-6">
                                    <span class="text-decoration-underline">Allergy:</span>
                                    <span class="
                                    @if($prescriptionTreatment->allergy != null) badge badge-warning text-dark
                                        @endif">
                                        {{ $prescriptionTreatment->allergy ?? '—'}}
                                    </span>
                                </p>
                            </div>
                            <div class="card-body">
                                <p class="fs-6"><span class="text-primary fw-bold text-decoration-underline">Doctor :</span> {{ $prescriptionTreatment->treatment->appointment->doctor->profile->name ?? $prescriptionTreatment->treatment->appointment->doctor->username }}</p>
                                <p class="fs-6"><span class="fw-bold text-decoration-underline">Treatment (ID - Title):</span> <span class="badge rounded-pill badge-dark">{{ $prescriptionTreatment->treatment_id }}</span> {{ $prescriptionTreatment->treatment->procedure_name }}</p>
                                <p class="fs-6"><span class="fw-bold text-decoration-underline">Appointment (ID - Title):</span> <span class="badge rounded-pill badge-dark">{{ $prescriptionTreatment->treatment->appointment_id }}</span> {{ $prescriptionTreatment->treatment->appointment->diagnosis }}</p>
                                <p class="fs-6">
                                    <span class="text-primary fw-bold text-decoration-underline ">Appointment Status:</span>
                                    <span class="
                                    @if($prescriptionTreatment->treatment->appointment->status == "scheduled") badge badge-primary
                                    @elseif($prescriptionTreatment->treatment->appointment->status == "completed") badge badge-success
                                    @else($prescriptionTreatment->status == "canceled") badge badge-danger
                                    @endif">
                                    {{ ucfirst($prescriptionTreatment->treatment->appointment->status) }}
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
