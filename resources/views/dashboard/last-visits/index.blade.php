@extends('layouts.dashboard.master')
@section('title') All Patients Last Visits ({{ \App\Models\LastVisit::count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Patients Last Visits ({{ \App\Models\LastVisit::count() }})</h5>
            <div class="row">
                <div class="col-md-9">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / All Patients Last Visits
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
                    <th>Patient</th>
                    <th>Created at</th>
                    <th>Created by</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th>Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                @foreach ($lastVisits as $lastVisit)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ \Carbon\Carbon::parse($lastVisit->last_visit_date)->format('d-m-Y') }}</td>
                    <td>
                        <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', $lastVisit->patient_id) }}">
                            {{ $lastVisit->patient->first_name . ' ' . $lastVisit->patient->last_name }}
                        </a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($lastVisit->created_at)->timezone('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                    <th>{{ $lastVisit->create_user->username }}</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th>
                        <form action="{{ route('patients.lastVisitsDestroy', $lastVisit->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $lastVisit->patient->first_name . ' ' . $lastVisit->patient->last_name }}) visit?');"title="{{"Delete?"}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
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
