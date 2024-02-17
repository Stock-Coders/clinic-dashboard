@extends('layouts.dashboard.master')
@section('title') All Medical Histories ({{ \App\Models\MedicalHistory::count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Medical Histories ({{ \App\Models\MedicalHistory::count() }})</h5>
            <div class="row">
                <div class="col-md-8">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / Medical Histories
                </div>
                {{-- <div class="col-md-1">
                    <a href="{{ route('medical-histories.pdf') }}" target="_blank" class="btn btn-secondary-gradien">PDF/Print</a>
                </div> --}}
                <div class="col-md-4">
                    <a href="{{ route('medical-histories.create') }}" class="btn btn-success-gradien">Create New Medical History</a>
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
                    <th>Patient</th>
                    <th style="background-color: rgb(94, 0, 56); color: snow;">Appointment</th>
                    <th style="background-color: rgb(104, 68, 89); color: snow;">Appointment's Prescription</th>
                    <th style="background-color: rgb(66, 94, 0); color: snow;">Treatment</th>
                    <th style="background-color: rgb(142, 158, 105); color: snow;">Treatment's Prescription</th>
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
                @foreach ($medicalHistories as $m_h_)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    {{-- <td>{{ $m_h_->id }}</td> --}}
                    <td>
                        @if($m_h_->appointment_id != null)
                            {{ $m_h_->appointment->patient->first_name . ' ' . $m_h_->appointment->patient->last_name }}
                        @elseif($m_h_->appointment_id != null)
                        @endif
                        {{ $m_h_->first_name .' '. $m_h_->last_name ?? '—' }}
                    </td>
                    <td class="text-center">{{ $m_h_->appointment ?? '—' }}</td>
                    <td class="text-center">{{ $m_h_->prescription ?? '—' }}</td>
                    <td class="text-center">{{ $m_h_->treatment ?? '—' }}</td>
                    <td class="text-center">{{ $m_h_->prescriptionTreatment ?? '—' }}</td>
                    <td>{{ optional($m_h_->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                    <td>{{ $m_h_->updated_at ? optional($m_h_->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $m_h_->create_user->username }}</th>
                    <th>{{ $m_h_->update_user->username ?? '—' }}</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('medical-histories.show', [$m_h_->id, $m_h_->first_name]) }}"title="{{ $m_h_->first_name .' '. $m_h_->last_name ?? '—' }}">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('medical-histories.edit', $m_h_->id) }}"title="Edit ({{ $m_h_->first_name .' '. $m_h_->last_name ?? '—' }})">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('medical-histories.destroy', $m_h_->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $m_h_->first_name . ' '. $m_h_->last_name ?? '—' }})?');"title="{{"Delete ($m_h_->first_name $m_h_->last_name)" ?? '—'}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
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
