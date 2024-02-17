@extends('layouts.dashboard.master')
@section('title', "Edit X-ray ($xray->title)")
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <strong class="card-title fs-2">
                Edit X-ray - <span class="text-primary">(ID: {{ $xray->id }})</span> for patient <span class="h5">(<span class="text-primary"><a class="text-decoration-underline fw-bold" href="{{ route('patients.show', $xray->patient->id) }}">{{ $xray->patient->first_name . ' ' . $xray->patient->last_name }}</a></span>)</span>
            </strong>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form action="{{ route('x-rays.update', $xray->id) }}" class="forms-sample" method="POST" id="alert-form" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    @include('dashboard.x-rays.single.single-form')
                    <button type="submit" class="btn btn-primary btn-md px-4 fs-8 shadow border-2 border-dark rounded me-2">Update</button>
                    <a href="{{ route('x-rays.index') }}" class="btn btn-dark btn-md px-4 fs-8 shadow border-2 border-dark rounded">Return to X-rays</a>
                </form>
              </div> <!-- /.col -->
            </div>
          </div>
        </div> <!-- / .card -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
@endsection

