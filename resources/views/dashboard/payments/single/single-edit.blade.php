@extends('layouts.dashboard.master')
@section('title')
Edit {{ $patient->first_name . ' ' . $patient->last_name }}'s Payment
@endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <strong class="card-title fs-2">
                Edit Payment (ID: <span class="text-primary fw-bold">{{ $payment->id }}</span>) for <a class="text-decoration-underline text-primary fw-bold" href="{{ route('patients.show', $patient->id) }}">{{ $patient->first_name . ' ' . $patient->last_name }}</a>
            </strong>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form action="{{ route('payments.update', $payment->id) }}" class="forms-sample" method="POST" id="alert-form">
                    @csrf
                    @method('PATCH')
                    @include('dashboard.payments.single.single-form')
                    <button type="submit" class="btn btn-primary btn-md px-4 fs-8 shadow border-2 border-dark rounded me-2">Update</button>
                    <a href="{{ route('payments.index') }}" class="btn btn-dark btn-md px-4 fs-8 shadow border-2 border-dark rounded">Return to payments</a>
                </form>
              </div> <!-- /.col -->
            </div>
          </div>
        </div> <!-- / .card -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
@endsection

