@extends('layouts.dashboard.master')
@section('title') All Prescriptions ({{ $prescriptions->count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Prescriptions ({{ $prescriptions->count() }})</h5>
            {{-- <span>
                <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('prescriptions.index') }}">Prescriptions</a> / All Prescriptions
            </span> --}}
            <div class="row">
                <div class="col-md-8">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / Prescriptions
                </div>
                <div class="col-md-1">
                    <a href="{{ route('prescriptions.index.pdf') }}" target="_blank" class="btn btn-secondary-gradien">PDF/Print</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('prescriptions.create') }}" class="btn btn-success-gradien">Create New Prescription</a>
                </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Prescription</th>
                    <th>Allergy</th>
                    <th>Appointment: (ID) - Title</th>
                    <th>Next Visit</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Created by (Doctor)</th>
                    <th>Updated by (Doctor)</th>
                    <th class="text-center">Print</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($prescriptions as $prescription)
                @php
                    // For limiting whole words
                        // $strippedPrescription = preg_replace('/<[^>]*>/', '', $prescription->prescription); // Remove HTML tags
                        // $words = str_word_count($strippedPrescription, 2); // Get an associative array of words
                        // $numberOfWordsToBeShown = 3;
                        // $limitedWords = array_slice($words, 0, $numberOfWordsToBeShown); // Limit to the first $numberOfWordsToBeShown words
                        // $limitedPrescription = implode(' ', $limitedWords) . (count($words) >= $numberOfWordsToBeShown ? '...' : ''); // Combine and add "..." if there are equal or more words

                    // For limiting characters
                        // Remove HTML tags
                        $strippedPrescription = preg_replace('/<[^>]*>/', '', $prescription->prescription);
                        // Limit to the desired number of characters
                        $numberOfCharactersToBeShown = 15; // Adjust this value as needed
                        $limitedPrescription = strlen($strippedPrescription) > $numberOfCharactersToBeShown ? substr($strippedPrescription, 0, $numberOfCharactersToBeShown) . '...' : $strippedPrescription; // Truncate the prescription text and add "..." if needed
                @endphp
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', [$prescription->appointment->patient_id, $prescription->appointment->patient->first_name]) }}">
                            {{ $prescription->appointment->patient->first_name .' '. $prescription->appointment->patient->last_name }}
                        </a>
                    </td>
                    <td>{!! $limitedPrescription !!}</td>
                    <td>{{ $prescription->allergy ?? '—' }}</td>
                    <td class="text-center">
                        ({{ $prescription->appointment->id }}) - {{$prescription->appointment->diagnosis  }}
                    </td>
                    <td>{{ $prescription->next_visit != null ? \Carbon\Carbon::parse($prescription->next_visit)->format('d-M-Y, h:i A') : '—' }}</td>
                    <td>{{ optional($prescription->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                    <td>{{ $prescription->updated_at ? optional($prescription->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $prescription->create_doctor->username }}</th>
                    <th>{{ $prescription->update_doctor->username ?? '—' }}</th>
                    <th class="text-center">
                        <a class="btn btn-info btn-xs px-2" href="{{ route('prescriptions.show.pdf', $prescription->id) }}">
                            <i class="icofont icofont-printer f-26"></i>
                        </a>
                    </th>
                    <th>
                        <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('prescriptions.show', $prescription->id) }}"title="{{ $prescription->appointment->patient->first_name }}'s appointment">
                            <i class="icofont icofont-open-eye f-24"></i>
                        </a>
                        <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('prescriptions.edit', $prescription->id) }}"title="Edit {{ $prescription->appointment->patient->first_name }}'s prescription">
                            <i class="fa fa-edit f-18"></i>
                        </a>
                        <form action="{{ route('prescriptions.destroy', $prescription->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $prescription->title }})?');"title="Delete {{ $prescription->appointment->patient->first_name }}'s prescription" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
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
