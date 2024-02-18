@extends('layouts.dashboard.master')
@section('title') {{ $patient->first_name . ' ' . $patient->last_name }}'s Treatments ({{ $allPatientTreatments->count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>
        @include('layouts.dashboard.includes.alert')
    </p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5><a href="{{ route('patients.show', $patient->id) }}" class="text-decoration-underline fw-bold">{{ $patient->first_name . ' ' . $patient->last_name }}</a>'s Treatments ({{ $allPatientTreatments->count() }})</h5>
            {{-- <span>
                <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('treatments.index') }}">Treatments</a> / All Treatments
            </span> --}}
            <div class="row">
                <div class="col-md-9">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / Treatments
                </div>
                <div class="col-md-3">
                    <a href="{{ route('treatments.create') }}" class="btn btn-success-gradien">Create New Treatment</a>
                </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Procedure Name</th>
                    <th>Treatment Type</th>
                    <th>Doctor</th>
                    <th>Status</th>
                    <th>Cost (EGP)</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Notes</th>
                    {{-- <th>Prescription ID</th> --}}
                    <th>Appointment ID</th>
                    <th>Created by</th>
                    <th>Updated by</th>
                    <th class="text-center">Print</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($allPatientTreatments as $treatment)
                @php
                    $words = str_word_count($treatment->notes, 2); // Get an associative array of words
                    $limitedWords = array_slice($words, 0, 4); // Limit to the first 4 words
                    $limitedNotes = implode(' ', $limitedWords) . (count($words) >= 4 ? '...' : ''); // Combine and add "..." if there are equal or more words
                @endphp
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $treatment->id }}</td>
                    <td>
                        {{-- @if (isset($treatment->prescription) || isset($treatment->appointment)) --}}

                        @if($treatment->prescription_id != null && $treatment->appointment_id == null)
                        <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', $treatment->prescription->appointment->patient_id) }}">
                            {{ $treatment->prescription->appointment->patient->first_name .' '. $treatment->prescription->appointment->patient->last_name }}
                        </a>
                        @else($treatment->prescription_id == null && $treatment->appointment_id != null)
                        <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', $treatment->appointment->patient_id) }}">
                            {{ $treatment->appointment->patient->first_name .' '. $treatment->appointment->patient->last_name }}
                        </a>
                        @endif

                        {{-- @endif --}}
                    </td>
                    <td>{{ $treatment->procedure_name }}</td>
                    <td>{{ ucfirst($treatment->treatment_type) }}</td>
                    <th>
                        @if($treatment->prescription_id != null && $treatment->appointment_id == null)
                            {{ $treatment->prescription->appointment->doctor->profile->name ?? $treatment->prescription->appointment->doctor->username }}
                        @else($treatment->prescription_id == null && $treatment->appointment_id != null)
                            {{ $treatment->appointment->doctor->profile->name ?? $treatment->appointment->doctor->username }}
                        @endif
                    </th>
                    <td class="text-center">
                        <span class="
                        @if($treatment->status == "scheduled") badge badge-info
                        @elseif($treatment->status == "completed") badge badge-success
                        @else($treatment->status == "canceled") badge badge-danger
                        @endif">
                            {{ ucfirst($treatment->status) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge rounded-pill badge-dark f-12">{{ $treatment->cost }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $treatment->treatment_date)->format('d-M-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($treatment->treatment_time)->format('h:i A') }}</td>
                    <td>{{ $treatment->notes !== null ? $limitedNotes : '—' }}</td>
                    {{-- <td class="text-center">{{ $treatment->prescription_id != null ? $treatment->prescription->id : '—' }}</td> --}}
                    <td class="text-center">
                        @if($treatment->appointment_id != null)
                            {{ $treatment->appointment_id }} {{-- Direct appointment in the treatment --}}
                        @else
                            {{ $treatment->prescription->appointment_id }} {{-- Indirect appointment in the treatment (through the prescription) --}}
                        @endif
                    </td>
                    <th>{{ $treatment->create_user->username }}</th>
                    <th>{{ $treatment->update_user->username ?? '—' }}</th>
                    <th class="text-center">
                        <a class="btn btn-info btn-xs px-2" href="{{ route('treatments.show.pdf', [$treatment->id]) }}">
                            <i class="icofont icofont-printer f-26"></i>
                        </a>
                    </th>
                    <th>
                        {{-- @if(isset($treatment->appointment)) --}}
                        <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('treatments.show', $treatment->id) }}"title="{{ $treatment->appointment_id != null && $treatment->prescription_id == null ? $treatment->appointment->patient->first_name : $treatment->prescription->appointment->patient->first_name }}'s treatment">
                            <i class="icofont icofont-open-eye f-24"></i>
                        </a>
                        {{-- @endif --}}
                        {{-- <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('treatments.edit', $treatment->id) }}"title="Edit ({{ $treatment->procedure_name }})">
                            <i class="fa fa-edit f-18"></i>
                        </a> --}}
                        <form action="{{ route('treatments.destroy', $treatment->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $treatment->procedure_name  }})?');"title="{{"Delete ($treatment->procedure_name )"}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                        </form>
                    </th>
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

@push('scripts')
<!-- Plugins JS start-->
<script src="{{ asset('/assets/dashboard/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/dashboard/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('/assets/dashboard/js/tooltip-init.js') }}"></script>
<!-- Plugins JS Ends-->
@endpush
