@extends('layouts.dashboard.master')
@section('title') All Prescriptions Treatments ({{ $prescriptionsTreatments->count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Prescriptions Treatments ({{ $prescriptionsTreatments->count() }})</h5>
            <div class="row">
                <div class="col-md-7">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / Prescriptions Treatments
                </div>
                <div class="col-md-1">
                    <a href="{{ route('prescriptions-treatments.index.pdf') }}" target="_blank" class="btn btn-secondary-gradien">PDF/Print</a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('prescriptions-treatments.create') }}" class="btn btn-success-gradien">Create New Prescription Treatment</a>
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
                    {{-- <th>Prescription</th> --}}
                    <th>Allergy</th>
                    <th>Treatment: (ID) - Title</th>
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
                @foreach ($prescriptionsTreatments as $p_t_)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        @if($p_t_->treatment->prescription_id == null)
                        <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', [$p_t_->treatment->appointment->patient_id, $p_t_->treatment->appointment->patient->first_name]) }}">
                            {{ $p_t_->treatment->appointment->patient->first_name .' '. $p_t_->treatment->appointment->patient->last_name }}
                        </a>
                        @else
                        <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', [$p_t_->treatment->prescription->appointment->patient_id, $p_t_->treatment->prescription->appointment->patient->first_name]) }}">
                            {{ $p_t_->treatment->prescription->appointment->patient->first_name .' '. $p_t_->treatment->prescription->appointment->patient->last_name }}
                        </a>
                        @endif
                    </td>
                    {{-- <td>{{ $p_t_->prescription }}</td> --}}
                    <td>{{ $p_t_->allergy ?? '—' }}</td>
                    <td class="text-center">({{ $p_t_->treatment->id }}) - {{$p_t_->treatment->procedure_name  }}</td>
                    <td>{{ $p_t_->next_visit != null ? \Carbon\Carbon::parse($p_t_->next_visit)->format('d-M-Y, h:i A') : '—' }}</td>
                    <td>{{ optional($p_t_->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                    <td>{{ $p_t_->updated_at ? optional($p_t_->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $p_t_->create_doctor->username }}</th>
                    <th>{{ $p_t_->update_doctor->username ?? '—' }}</th>
                    <th class="text-center">
                        <a class="btn btn-info btn-xs px-2" href="{{ route('prescriptions-treatments.show.pdf', $p_t_->id) }}">
                            <i class="icofont icofont-printer f-26"></i>
                        </a>
                    </th>
                    <th>
                        @if($p_t_->treatment->prescription_id == null && $p_t_->treatment->appointment_id != null)
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('prescriptions-treatments.show', $p_t_->id) }}"title="{{ $p_t_->treatment->appointment->patient->first_name }}'s appointment">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('prescriptions-treatments.edit', $p_t_->id) }}"title="Edit {{ $p_t_->treatment->appointment->patient->first_name }}'s prescription">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('prescriptions-treatments.destroy', $p_t_->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $p_t_->treatment->appointment->patient->first_name . ' ' . $p_t_->treatment->appointment->patient->last_name }})?');"title="Delete {{ $p_t_->treatment->appointment->patient->first_name }}'s prescription" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                            </form>
                        @else
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('prescriptions.show', $p_t_->id) }}"title="{{ $p_t_->treatment->appointment->patient->first_name }}'s appointment">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('prescriptions-treatments.edit', $p_t_->id) }}"title="Edit {{ $p_t_->treatment->prescription->appointment->patient->first_name }}'s prescription">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('prescriptions-treatments.destroy', $p_t_->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $p_t_->treatment->prescription->appointment->patient->first_name . ' ' . $p_t_->treatment->prescription->appointment->patient->last_name }})?');"title="Delete {{ $p_t_->treatment->prescription->appointment->patient->first_name }}'s prescription" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                            </form>
                        @endif
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
