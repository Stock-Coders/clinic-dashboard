@extends('layouts.dashboard.master')
@section('title')
Edit {{ $appointment->patient->first_name }}'s Appointment
@endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <strong class="card-title fs-2">
                Edit Appointment (ID: <span class="text-primary">{{ $appointment->id }}</span>) for <a class="text-decoration-underline text-primary" href="{{ route('patients.show', [$appointment->patient_id, $appointment->patient->first_name]) }}">{{ $appointment->patient->first_name . ' ' . $appointment->patient->last_name }}</a>
            </strong>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form action="{{ route('appointments.update', $appointment->id) }}" class="forms-sample" method="POST" id="alert-form">
                    @csrf
                    @method('PATCH')
                    @include('dashboard.appointments.form')
                    <button type="submit" class="btn btn-primary btn-md px-4 fs-8 shadow border-2 border-dark rounded me-2">Update</button>
                    <a href="{{ route('appointments.index') }}" class="btn btn-dark btn-md px-4 fs-8 shadow border-2 border-dark rounded">Return to appointments</a>
                </form>
              </div> <!-- /.col -->
            </div>
          </div>
        </div> <!-- / .card -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
@endsection

