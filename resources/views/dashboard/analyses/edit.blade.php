@extends('layouts.dashboard.master')
@section('title')
Edit {{ $analysis->patient->first_name }}'s Analysis
@endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <strong class="card-title fs-2">
                Edit Analysis for <span class="text-primary">{{ $analysis->patient->first_name . ' ' . $analysis->patient->last_name }}</span> (ID: <span class="text-primary">{{ $analysis->id }}</span>)
            </strong>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form action="{{ route('analyses.update', $analysis->id) }}" class="forms-sample" method="POST" id="alert-form">
                    @csrf
                    @method('PATCH')
                    @include('dashboard.analyses.form')
                    <button type="submit" class="btn btn-primary btn-md px-4 fs-8 shadow border-2 border-dark rounded me-2">Update</button>
                    <a href="{{ route('analyses.index') }}" class="btn btn-dark btn-md px-4 fs-8 shadow border-2 border-dark rounded">Return to analyses</a>
                </form>
              </div> <!-- /.col -->
            </div>
          </div>
        </div> <!-- / .card -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
@endsection

