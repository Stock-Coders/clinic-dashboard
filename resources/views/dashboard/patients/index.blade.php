@extends('layouts.dashboard.master')
@section('title') All Patients ({{ \App\Models\Patient::count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Patients ({{ \App\Models\Patient::count() }})</h5>
            <div class="row">
                <div class="col-md-8">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / Patients
                </div>
                <div class="col-md-1">
                    <a href="{{ route('patients.pdf') }}" target="_blank" class="btn btn-secondary-gradien">PDF/Print</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('patients.create') }}" class="btn btn-success-gradien">Create New patient</a>
                </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    {{-- <th>ID</th> --}}
                    <th>Full Name</th>
                    <th>Last Visit</th>
                    <th>Chief Complaint</th>
                    <th>Chronic Disease</th>
                    <th>Appointments</th>
                    <th>Treatments</th>
                    <th>X-rays</th>
                    {{-- <th>Email</th> --}}
                    <th>Phone</th>
                    {{-- <th>Emergency Phone</th> --}}
                    {{-- <th>WhatsApp</th> --}}
                    {{-- <th>Date of Birth</th> --}}
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Created by</th>
                    <th>Updated by</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th class="text-center">Action</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($patients as $patient)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    {{-- <td>{{ $patient->id }}</td> --}}
                    <td>
                        <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', [$patient->id, $patient->first_name]) }}">
                            {{ $patient->first_name .' '. $patient->last_name }}
                        </a>
                    </td>
                    <td>
                        @if ($patient->lastVisits->isNotEmpty())
                            {{ \Carbon\Carbon::parse($patient->lastVisits->last()->last_visit_date)->format('d M, Y') }}
                        @else
                            <span class="text-danger">No visits yet.</span>
                        @endif
                    </td>
                    <td>
                        @if ($patient->chief_complaint == "badly_aesthetic")
                            Badly Aesthetic
                        @elseif($patient->chief_complaint == "severe_pain")
                            Severe Pain
                        @else
                            Mastication
                        @endif
                    </td>
                    <td>{{ $patient->chronic_disease ?? '—' }}</td>
                    <td>
                        <span class="fs-6">({{ $patient->appointment->count() }})</span>
                    </td>
                    <td>
                        <span class="fs-6">
                            @php
                                $patientTreatsDirect = $patient->appointment->flatMap->treatment->count();
                                $patientTreatsIndirect = 0;
                                foreach ($patient->appointment as $patientAppointment) {
                                    if ($patientAppointment->prescription) {
                                        $patientTreatsIndirect += $patientAppointment->prescription->treatment->count();
                                    }
                                }
                                $totalPatientTreatments = $patientTreatsDirect + $patientTreatsIndirect;
                            @endphp
                            ({{ $totalPatientTreatments }})
                        </span>
                    </td>
                    <td>
                        <span class="fs-6">({{ $patient->xray->count() }})</span>
                        @if($patient->xray->count() > 0)
                            <a class="text-decoration-underline fw-bold" href="{{ route('patient.x-rays.index', $patient->id) }}">
                            <span class="badge badge-dark text-light fw-bolder mt-1">
                            @if($patient->xray->count() > 1)
                            Check them <i class="icon-hand-point-up f-14"></i>
                            @else
                            Check it <i class="icon-hand-point-up f-14"></i>
                            @endif
                            </span>
                            </a>
                        {{-- @else
                        Not yet! --}}
                        @endif
                    </td>
                    {{-- <td>{{ $patient->email ?? '—' }}</td> --}}
                    <td>{{ $patient->phone}}</td>
                    {{-- <td>{{ $patient->emergency_phone ?? '—' }}</td> --}}
                    {{-- <td>{{ $patient->whatsapp ?? '—' }}</td> --}}
                    {{-- <td>{{ \Carbon\Carbon::parse($patient->dob)->format('d-m-Y') }}</td> --}}
                    <td>{{ \Carbon\Carbon::parse($patient->dob)->diffInYears(\Carbon\Carbon::now()) }}</td>
                    <td>{{ ucfirst($patient->gender) }}</td>
                    <td>{{ $patient->address ?? '—' }}</td>
                    <td>{{ optional($patient->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                    <td>{{ $patient->updated_at ? optional($patient->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $patient->create_user->username }}</th>
                    <th>{{ $patient->update_user->username ?? '—' }}</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('patients.show', [$patient->id, $patient->first_name]) }}"title="{{ $patient->first_name .' '. $patient->last_name }}">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('patients.edit', $patient->id) }}"title="Edit ({{ $patient->first_name .' '. $patient->last_name }})">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('patients.destroy', $patient->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $patient->first_name . ' '. $patient->last_name }})?');"title="{{"Delete ($patient->first_name $patient->last_name)"}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                            </form>
                        </div>
                    </th>
                    @endif
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Zero Configuration  Ends-->
    </div>
  </div>
@endsection

@push('styles')
<!-- Plugins css start-->
<link rel="stylesheet" type="text/css" href="{{ asset('/assets/dashboard/css/datatables.css') }}">
@endpush

{{-- @push('styles')
<script src="{{asset('/assets/dashboard/js/jquery-3.5.1.min.js')}}"></script>
<script src="{{ asset('/assets/dashboard/js/jquery.printPage.js') }}"></script>
@endpush --}}

@push('scripts')
<!-- Plugins JS start-->
<script src="{{ asset('/assets/dashboard/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/dashboard/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('/assets/dashboard/js/tooltip-init.js') }}"></script>
<!-- Plugins JS Ends-->
@endpush
