@extends('layouts.dashboard.master')
@section('title') {{ $patient->first_name . ' ' . $patient->last_name }} Last Visits ({{ \App\Models\LastVisit::where('patient_id', $patient->id)->count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>
                <span class="text-primary fw-bold">
                    <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', $patient->id) }}">
                        {{ $patient->first_name . ' ' . $patient->last_name }}
                    </a>
                </span><span class="text-dark" style="text-transform: lowercase;">'s</span>
                Last Visits
                ({{ \App\Models\LastVisit::where('patient_id', $patient->id)->count() }})
            </h5>
            <div class="row">
                <div class="col-md-9">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('patients.lastVisitsIndex') }}">All Last Visits</a> / {{ $patient->first_name . ' ' . $patient->last_name }} Last Visits
                </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Last Visit Date</th>
                    <th>Created at</th>
                    <th>Created by</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th>Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                @foreach ($patientLastVisits as $patientLastVisit)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ \Carbon\Carbon::parse($patientLastVisit->last_visit_date)->format('d-m-Y') }}</td>
                    <th>{{ optional($patientLastVisit->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</th>
                    <th>{{ $patientLastVisit->create_user->username }}</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th>
                        <form action="{{ route('patients.lastVisitsDestroy', $patientLastVisit->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $patientLastVisit->patient->first_name . ' ' . $patientLastVisit->patient->last_name }}) visit?');"title="{{"Delete?"}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                        </form>
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
