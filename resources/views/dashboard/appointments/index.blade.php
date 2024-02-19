@extends('layouts.dashboard.master')
@section('title') All Appointments ({{ \App\Models\Appointment::count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>
        @include('dashboard.appointments.undo-redo')
        @include('layouts.dashboard.includes.alert')
    </p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Appointments ({{ \App\Models\Appointment::count() }})</h5>
            {{-- <span>
                <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('appointments.index') }}">Appointments</a> / All Appointments
            </span> --}}
            <div class="row">
                <div class="col-md-8">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / Appointments
                </div>
                <div class="col-md-1">
                    <a href="{{ route('appointments.index.pdf') }}" target="_blank" class="btn btn-secondary-gradien">PDF/Print</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('appointments.create') }}" class="btn btn-success-gradien">Create New Appointment</a>
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
                    <th>Reason</th>
                    <th>Diagnosis</th>
                    <th>Status</th>
                    <th>Cost (EGP)</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Doctor</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Created by</th>
                    <th>Updated by</th>
                    <th class="text-center">Print</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($appointments as $appointment)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $appointment->id }}</td>
                    <td>
                        <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', [$appointment->patient_id, $appointment->patient->first_name]) }}">
                            {{ $appointment->patient->first_name .' '. $appointment->patient->last_name }}
                        </a>
                    </td>
                    <td class="text-center">
                        @if($appointment->appointment_reason == 'examination')
                        <span class="badge badge-info fw-bolder f-14">Examination</span>
                        @else
                        <span class="badge badge-warning text-dark fw-bolder f-14">Re-examination</span>
                        @endif
                    </td>
                    <td class="@if($appointment->diagnosis == null) text-center @endif">
                        @if($appointment->diagnosis != null)
                            <span>{{ $appointment->diagnosis }}</span>
                        @else
                            <span class="text-danger fw-bold">Unsigned</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="
                        @if($appointment->status == "scheduled") badge badge-info
                        @elseif($appointment->status == "completed") badge badge-success
                        @else($appointment->status == "canceled") badge badge-danger
                        @endif">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge rounded-pill badge-dark f-12">{{ $appointment->cost }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $appointment->appointment_date)->format('d-M-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                    <td>{{ $appointment->doctor->profile->name ?? $appointment->doctor->username }}</td>
                    <td>{{ optional($appointment->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                    <td>{{ $appointment->updated_at ? optional($appointment->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $appointment->create_user->username }}</th>
                    <th>{{ $appointment->update_user->username ?? '—' }}</th>
                    <th class="text-center">
                        <a class="btn btn-info btn-xs px-2" href="{{ route('appointments.show.pdf', [$appointment->id]) }}">
                            <i class="icofont icofont-printer f-26"></i>
                        </a>
                    </th>
                    <th>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('appointments.show', $appointment->id) }}"title="{{ $appointment->patient->first_name }} appointment">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('appointments.edit', $appointment->id) }}"title="Edit ({{ $appointment->patient->first_name }}) appointment">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $appointment->patient->first_name . ' '. $appointment->patient->last_name }})\'s appointment?');"title="Delete (<?php echo $appointment->patient->first_name . '\'s appointment'; ?>)" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                            </form>
                        </div>
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
