@extends('layouts.dashboard.master')
@section('title', "Patient | $patient->first_name $patient->last_name")
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    Add Last Visit For&nbsp;<span class="text-success fw-bold">{{ $patient->first_name }}</span>?
                    <a href="{{ route('patients.lastVisitsCreate', $patient->id) }}"><i class="icofont icofont-meeting-add text-success f-60"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Create Payment For&nbsp;<span class="text-danger fw-bold">{{ $patient->first_name }}</span>
                    <a target="_blank" href="{{ route('patient.payments.create', $patient->id) }}"><i class="icofont icofont-money text-danger f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Create X-ray For&nbsp;<span class="text-warning fw-bold">{{ $patient->first_name }}</span>?
                    <a href="{{ route('patient.x-rays.create', $patient->id) }}"><i class="icofont icofont-tooth text-warning f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('patients.edit', $patient->id) }}">Edit The Current Patient</a>
            </div>
            <strong class="card-title">
                <p class="fs-5"><span class="text-decoration-underline">Patient ID:</span> <span class="badge rounded-pill badge-dark">{{ $patient->id }}</span></p>
                <p class="fs-5"><span class="text-decoration-underline">Patient Full Name:</span> <span style="background-color: rgb(235, 235, 235);" class="text-dark fw-bold p-1 rounded">{{ $patient->first_name .' '. $patient->last_name }}</span></p>
            </strong>
            <div class="d-flex justify-content-center">
                <img src='{{asset("/assets/dashboard/images/custom-images/patients/images/$patient->image")}}' alt="Patient Image?" width="200">
            </div>
            </div>
            <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                {{-- Start - Container-fluid --}}
                <div class="container-fluid">
                    <div class="mb-1">
                        <a class="text-decoration-underline fw-bold" href="{{ route('patient.payments.index', $patient->id) }}">Click here</a> to view all the <span class="fw-bold">payments</span> for the current patient.
                    </div>
                    <div class="card">
                        <div class="row product-page-main">
                            <div class="col-sm-12">
                                <ul class="nav nav-tabs border-tab mb-0" id="top-tab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="information-tab" data-bs-toggle="tab" href="#information" role="tab" aria-controls="information" aria-selected="false">Information</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="appointments-tab" data-bs-toggle="tab" href="#appointments" role="tab" aria-controls="appointments" aria-selected="false">Appointments ({{ \App\Models\Appointment::where('patient_id', $patient->id)->count() ?? 0 }})</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="treatments-tab" data-bs-toggle="tab" href="#treatments" role="tab" aria-controls="treatments" aria-selected="true">Treatments ({{ $totalPatientTreatmentsCount }})</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="x-rays-tab" data-bs-toggle="tab" href="#x-rays" role="tab" aria-controls="x-rays" aria-selected="true">X-rays ({{ \App\Models\XRay::where('patient_id', $patient->id)->count() ?? 0 }})</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="medical-history-tab" data-bs-toggle="tab" href="#medical-history" role="tab" aria-controls="medical-history" aria-selected="true">Medical History (0)</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="receipts-tab" data-bs-toggle="tab" href="#receipts" role="tab" aria-controls="receipts" aria-selected="true">Receipts</a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>
                                <div class="tab-content" id="top-tabContent">
                                    <div class="tab-pane fade active show" id="information" role="tabpanel" aria-labelledby="information-tab">
                                        <p class="mb-0 m-t-20">
                                            <span class="text-decoration-underline fw-bold text-primary fs-4">Last Visit:</span>
                                            @if ($patient->lastVisits->isNotEmpty())
                                                {{ \Carbon\Carbon::parse($patient->lastVisits->last()->last_visit_date)->format('d M, Y') }}
                                                <span class="text-decoration-underline fw-bold f-2">
                                                    <a style="color:rgb(210, 165, 4);" href="{{ route('patients.lastVisitsShow', [$patient->id, $patient->first_name]) }}">
                                                        (Click here to view all the visits for the current patient!)
                                                    </a>
                                                </span>
                                            @else
                                                <span class="text-danger">No visits yet.</span>
                                            @endif
                                        </p>
                                        <div class="d-flex justify-content-between m-t-20">
                                            <div class="row">
                                                <p class="mb-0 m-t-10">
                                                    <span class="text-decoration-underline fw-bold">Gender:</span> <span>
                                                        @if($patient->gender == "female")
                                                            {{ ucfirst($patient->gender) }} <i class="fa fa-venus f-22" aria-hidden="true"></i>
                                                        @else
                                                            {{ ucfirst($patient->gender) }} <i class="fa fa-mars f-22" aria-hidden="true"></i>
                                                        @endif
                                                    </span>
                                                </p>
                                                <p class="mb-0 m-t-10">
                                                    <span class="text-decoration-underline fw-bold">Date of Birth:</span>
                                                    <span>
                                                        {{ \Carbon\Carbon::parse($patient->dob)->format('d M, Y') }}
                                                        (Age: {{ \Carbon\Carbon::parse($patient->dob)->diffInYears(\Carbon\Carbon::now()) }})
                                                    </span>
                                                </p>
                                                <p class="mb-0 m-t-10">
                                                    <span class="text-decoration-underline fw-bold">Chief Complaint:</span>
                                                    <span>
                                                        @if ($patient->chief_complaint == "badly_aesthetic")
                                                            Badly Aesthetic
                                                        @elseif($patient->chief_complaint == "severe_pain")
                                                            Severe Pain
                                                        @else
                                                            Mastication
                                                        @endif
                                                    </span>
                                                </p>
                                                <p class="mb-0 m-t-10">
                                                    <span class="text-decoration-underline fw-bold">Chronic Disease</span>
                                                    @if($patient->chronic_disease == null) <span class="text-danger"> @else <span class="text-muted"> @endif
                                                    {{ $patient->chronic_disease ?? 'N/A' }}</span>
                                                </p>
                                            </div>
                                            <div class="row">
                                                <p class="mb-0 m-t-10">
                                                    <span class="text-decoration-underline fw-bold">Email:</span>
                                                    @if($patient->email == null) <span class="text-danger"> @else <span class="text-muted"> @endif
                                                    {{ $patient->email ?? 'N/A' }}</span>
                                                </p>
                                                <p class="mb-0 m-t-10">
                                                    <span class="text-decoration-underline fw-bold">Phone:</span> <span>{{ $patient->phone }}</span>
                                                </p>
                                                <p class="mb-0 m-t-10">
                                                    <span class="text-decoration-underline fw-bold">Emergency Phone:</span>
                                                    @if($patient->emergency_phone == null) <span class="text-danger"> @else <span class="text-muted"> @endif
                                                    {{ $patient->emergency_phone ?? 'N/A' }}</span>
                                                </p>
                                                <p class="mb-0 m-t-10">
                                                    <span class="text-decoration-underline fw-bold">WhatsApp:</span>
                                                    @if($patient->whatsapp == null) <span class="text-danger"> @else <span class="text-muted"> @endif
                                                    {{ $patient->whatsapp ?? 'N/A' }}</span>
                                                </p>
                                                <p class="mb-0 m-t-10">
                                                    <span class="text-decoration-underline fw-bold">Address:</span>
                                                    @if($patient->address == null) <span class="text-danger"> @else <span class="text-muted"> @endif
                                                    {{ $patient->address ?? 'N/A' }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="appointments" role="tabpanel" aria-labelledby="appointments-tab">
                                        <p class="mb-0 m-t-20">
                                            <a class="text-primary fw-bold text-decoration-underline" href="{{ route('appointmentsOfPatient.showIndex', $patient->id) }}">Click here</a> to see all the appointments of the current patient.
                                        </p>
                                        <p class="mb-0 m-t-10">
                                            <ol type="1" reversed>
                                            @forelse ($patientAppointments as $patientAppointment)
                                            <li><a class="text-decoration-underline fw-bold" href="{{ route('appointments.show', $patientAppointment->id) }}">{{ $patientAppointment->diagnosis }}</a> ({{ \Carbon\Carbon::createFromFormat('Y-m-d', $patientAppointment->appointment_date)->format('d-M-Y') . ' | ' . \Carbon\Carbon::parse($patientAppointment->appointment_time)->format('h:i A') }})</li>
                                            @empty
                                            <span class="text-muted">No Appointments yet.</span>
                                            @endforelse
                                            </ol>
                                        </p>
                                    </div>
                                    <div class="tab-pane fade" id="treatments" role="tabpanel" aria-labelledby="treatments-tab">
                                        <p class="mb-0 m-t-20">
                                            <ol type="1" reversed>
                                            @forelse ($allPatientTreatments as $patientTreat)
                                            <li><a class="text-decoration-underline fw-bold" href="{{ route('treatments.show', $patientTreat->id) }}">{{ $patientTreat->procedure_name }}</a> (<span class="fw-bold">{{ ucfirst($patientTreat->treatment_type) }}</span>) ({{ \Carbon\Carbon::createFromFormat('Y-m-d', $patientTreat->treatment_date)->format('d-M-Y') . ' | ' . \Carbon\Carbon::parse($patientTreat->treatment_time)->format('h:i A') }})</li>
                                            @empty
                                            <span class="text-muted">No Treatments yet.</span>
                                            @endforelse
                                            </ol>
                                        </p>
                                    </div>
                                    <div class="tab-pane fade" id="x-rays" role="tabpanel" aria-labelledby="x-rays-tab">
                                        <p class="mb-0 m-t-20">
                                            @php
                                                $patientXRays      = \App\Models\XRay::where('patient_id', $patient->id)->latest()->get();
                                                $patientLatestXRay = $patientXRays->first();
                                                // $patientXRaysCount = \App\Models\XRay::where('patient_id', $patient->id)->count();
                                            @endphp
                                            {{-- @if(\App\Models\XRay::where('patient_id', $patient->id)->count() > 0) Check them. @endif --}}
                                            <ol type="1" reversed>
                                            @forelse ($patientXRays as $patientXRay)
                                            <li>@if($patientXRay == $patientLatestXRay) <span class="fw-bold">Latest X-ray &rightarrow;</span> @endif<a class="text-decoration-underline fw-bold" href="{{ route('patient.x-rays.index', $patientXRay->patient_id) }}">{{ $patientXRay->title }}</a> ({{ optional($patientXRay->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }})</li>
                                            @empty
                                            <span class="text-muted">No X-rays yet.</span>
                                            @endforelse
                                            </ol>
                                        </p>
                                    </div>
                                    <div class="tab-pane fade" id="medical-history" role="tabpanel" aria-labelledby="medical-history-tab">
                                        <p class="mb-0 m-t-20">Lorem medical-history is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1502s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                    </div>
                                    <div class="tab-pane fade" id="receipts" role="tabpanel" aria-labelledby="receipts-tab">
                                        <p class="mb-0 m-t-20">Lorem receipts is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1503s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
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
