@extends('layouts.dashboard.master')
@section('title') X-rays | {{ $patient->first_name . ' ' . $patient->last_name }} ({{ $patientXRays->count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All <a class="text-decoration-underline" href="{{ route('patients.show', $patient->id) }}">{{ $patient->first_name . ' ' . $patient->last_name }}</a>'s X-rays ({{ $patientXRays->count() }})</h5>
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('x-rays.index') }}">X-rays</a> / All {{ $patient->first_name . ' ' . $patient->last_name }}'s X-rays
                </div>
                <div class="col-md-3">
                    <form action="{{ route('patient.x-rays.clear', $patient->id) }}" method="POST" id="x-rays-clear">
                        @csrf
                        @method('DELETE')
                        {{-- <a href="javascript:void(0);" onclick="return confirm('Are you sure that you want to delete all the x-rays for ('.$patient->first_name . ' ' . $patient->last_name.')?'); document.querySelector('#x-rays-clear').submit();" title="Delete all {{ $patient->first_name.'\'s' }} x-rays?" class="btn btn-danger">Clear All {{ $patient->first_name }}'s X-rays</a> --}}
                        <button type="submit" onclick="return confirm('Are you sure that you want to delete all the x-rays for ('.$patient->first_name . ' ' . $patient->last_name.')?'); document.querySelector('#x-rays-clear').submit();" title="Delete all {{ $patient->first_name.'\'s' }} x-rays?" class="btn btn-danger">Clear All {{ $patient->first_name }}'s X-rays</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('patient.x-rays.create', $patient->id) }}" class="btn btn-success-gradien">Create New X-ray for {{ $patient->first_name . ' ' . $patient->last_name }}</a>
                </div>
            </div>
          </div>
          <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('patient.x-rays.gallery', $patient->id) }}" class="text-decoration-underline fw-bold">Click here</a> to see {{ $patient->first_name }}'s <span class="fw-bold">X-ray gallery</span>.
            </div>
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>X-ray ID</th>
                    <th>Chief Complaint</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Timing</th>
                    <th>Cost (EGP)</th>
                    <th>Notes</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Created by</th>
                    <th>Updated by</th>
                    <th class="text-center">Print</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($patientXRays as $patientXRay)
                @php
                    $words = str_word_count($patientXRay->notes, 2); // Get an associative array of words
                    $limitedWords = array_slice($words, 0, 4); // Limit to the first 4 words
                    $limitedNotes = implode(' ', $limitedWords) . (count($words) >= 4 ? '...' : ''); // Combine and add "..." if there are equal or more words
                @endphp
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $patientXRay->id }}</td>
                    <td>
                        @if ($patientXRay->patient->chief_complaint == "badly_aesthetic")
                            Badly Aesthetic
                        @elseif($patientXRay->patient->chief_complaint == "severe_pain")
                            Severe Pain
                        @else
                            Mastication
                        @endif
                    </td>
                    <td>{{ $patientXRay->title ?? '—' }}</td>
                    <td><img src="{{ Storage::url($patientXRay->image) }}" alt="—" width="70"></td>
                    <td>{{ $patientXRay->timing == "in_between" ? "In Between" : ucfirst($patientXRay->timing) }}</td>
                    <td class="text-center">
                        <span class="badge rounded-pill badge-dark f-12">{{ $patientXRay->cost }}</span>
                    </td>
                    <td>{{ $patientXRay->notes !== null ? $limitedNotes : '—' }}</td>
                    <td>{{ optional($patientXRay->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                    <td>{{ $patientXRay->updated_at ? optional($patientXRay->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $patientXRay->create_user->username }}</th>
                    <th>{{ $patientXRay->update_user->username ?? '—' }}</th>
                    <th class="text-center">
                        {{-- <a class="btn btn-info btn-xs px-2" href="{{ route('x-rays.show.pdf', [$patientXRay->id]) }}"> --}}
                            <i class="icofont icofont-printer f-26"></i>
                        {{-- </a> --}}
                    </th>
                    <th>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('x-rays.show', $patientXRay->id) }}"title="Show {{ $patientXRay->patient->first_name }}'s x-ray">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('patient.x-rays.edit', $patientXRay->id) }}"title="Edit {{ $patientXRay->patient->first_name }}'s x-ray">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('x-rays.destroy', $patientXRay->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete {{ $patientXRay->patient->first_name . ' ' . $patientXRay->patient->last_name }}\'s X-ray? with ID ({{ $patientXRay->id }})');"title="Delete {{ $patientXRay->patient->first_name }}'s x-ray?" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
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
