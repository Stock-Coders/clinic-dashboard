@extends('layouts.dashboard.master')
@section('title') All Analyses ({{ \App\Models\Analysis::count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Analyses ({{ \App\Models\Analysis::count() }})</h5>
            {{-- <span>
                <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('analyses.index') }}">Analyses</a> / All Analyses
            </span> --}}
            <div class="row">
                <div class="col-md-9">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / All Analyses
                </div>
                <div class="col-md-3">
                    <a href="{{ route('analyses.create') }}" class="btn btn-success-gradien">Create New Analysis</a>
                </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Medical Lab Name</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Recommendations</th>
                    <th>Notes</th>
                    <th>Patient</th>
                    <th>Doctor</th>
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
                @foreach ($analyses as $analysis)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ ucfirst($analysis->medical_lab_name) }}</td>
                    <td>{{ ucfirst($analysis->analysis_type) }}</td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $analysis->analysis_date)->format('d-M-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($analysis->analysis_time)->format('h:i A') }}</td>
                    <td>{{ $analysis->recommendations ?? '—' }}</td>
                    <td>{{ $analysis->notes ?? '—' }}</td>
                    <td>
                        <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', $analysis->patient_id) }}">
                            {{ $analysis->patient->first_name .' '. $analysis->patient->last_name }}
                        </a>
                    </td>
                    <td>{{ $analysis->doctor->profile->name ?? $analysis->doctor->username }}</td>
                    <td>{{ optional($analysis->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                    <td>{{ $analysis->updated_at ? optional($analysis->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $analysis->create_user->username }}</th>
                    <th>{{ $analysis->update_user->username ?? '—' }}</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th>
                        <div class="d-flex justify-content-between">
                            {{-- <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('analyses.show', $analysis->id) }}"title="{{ $analysis->patient->first_name }} analysis">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a> --}}
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('analyses.edit', $analysis->id) }}"title="Edit ({{ $analysis->patient->first_name }}) analysis">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('analyses.destroy', $analysis->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $analysis->patient->first_name . ' '. $analysis->patient->last_name }})\'s analysis?');"title="Delete (<?php echo $analysis->patient->first_name . ' ' . $analysis->patient->last_name; ?>)" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
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

@push('scripts')
<!-- Plugins JS start-->
<script src="{{ asset('/assets/dashboard/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/dashboard/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('/assets/dashboard/js/tooltip-init.js') }}"></script>
<!-- Plugins JS Ends-->
@endpush
