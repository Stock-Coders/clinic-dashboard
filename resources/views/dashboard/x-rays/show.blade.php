@extends('layouts.dashboard.master')
@section('title') X-ray | {{ $xray->patient->first_name . ' ' . $xray->patient->last_name }} @endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    Add Last Visit For&nbsp;<span class="text-success fw-bold">{{ $xray->patient->first_name }}</span>?
                    <a href="{{ route('patients.lastVisitsCreate', $xray->patient->id) }}"><i class="icofont icofont-meeting-add text-success f-60"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Add X-ray For&nbsp;<span class="text-warning fw-bold">{{ $xray->patient->first_name }}</span>?
                    <a href="{{ route('patient.x-rays.create', $xray->patient->id) }}"><i class="icofont icofont-tooth text-warning f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('x-rays.edit', $xray->id) }}">Edit The Current X-ray</a>
            </div>
            <strong class="card-title">
                <p class="fs-5"><span class="text-decoration-underline">X-ray ID:</span> <span class="badge rounded-pill badge-dark">{{ $xray->id }}</span></p>
                <p class="fs-5"><span class="text-decoration-underline">Patient ID:</span> <span class="badge rounded-pill badge-dark">{{ $xray->patient->id }}</span></p>
                <p class="fs-5"><span class="text-decoration-underline">Patient Full Name:</span> <span style="background-color: rgb(235, 235, 235);" class="text-dark fw-bold p-1 rounded">{{ $xray->patient->first_name .' '. $xray->patient->last_name }}</span></p>
            </strong>
            <div class="d-flex justify-content-center">
                {{-- @php $patientImage = $xray->patient->image; @endphp
                <img src='{{asset("/assets/dashboard/images/custom-images/patients/images/$patientImage")}}' alt="Patient Image?" width="300" loading="lazy"> --}}
                <img src="{{ Storage::url($xray->image) }}" alt="Patient's X-ray Image?" width="300">
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                {{-- Start - Container-fluid --}}
                <div class="container-fluid">
                    <div class="row">
                        <div class="d-flex justify-content-evenly mb-1">
                            <div>
                                <a class="text-primary fw-bold text-decoration-underline" href="{{ route('patient.x-rays.gallery', $xray->patient->id) }}">Click here</a> to see the <span class="fw-bold">X-ray gallery</span> of the current patient.
                            </div>
                            <div>
                                <a class="text-primary fw-bold text-decoration-underline" href="{{ route('patient.x-rays.index', $xray->patient->id) }}">Click here</a> to see all the <span class="fw-bold">X-rays</span> of the current patient.
                            </div>
                        </div>
                      <div class="col-sm-12">
                        <div class="card">
                          <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="text-decoration-underline">Title: </h5><span class="@if($xray->title == null) text-danger @endif">{{ $xray->title != null ? $xray->title : 'N/A' }}</span>
                                </div>
                                <div>
                                    <p><span class="text-decoration-underline fw-bold">Created at:</span> {{ optional($xray->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</p>
                                    <p><span class="text-decoration-underline fw-bold">Updated at:</span> {{ $xray->updated_at ? optional($xray->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</p>
                                </div>
                            </div>
                          </div>
                          <div class="card-body">
                            <span class="text-decoration-underline h6">Cost:</span> <span class="badge rounded-pill badge-dark f-12">{{ $xray->cost }} EGP</span></p>
                            <p>
                                <span class="text-decoration-underline h6">Timing:</span>
                                @if($xray->timing == "in_between")
                                <span>In Between</span>
                                @else
                                <span>{{ ucfirst($xray->timing) }}</span>
                                @endif
                            </p>
                            <p>
                                <span class="bg-warning rounded-pill p-2 text-dark fw-bold h6">Notes <i class="icofont icofont-arrow-right f-18"></i></span>
                                @if($xray->notes != null)
                                <span>{{ $xray->notes }}</span>
                                @else
                                <span class="text-danger">N/A</span>
                                @endif
                            </p>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
                {{-- End - Container-fluid --}}
              </div> <!-- /.col -->
            </div>
          </div>
        </div> <!-- / .card -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
@endsection
