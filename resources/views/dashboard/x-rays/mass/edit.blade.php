@extends('layouts.dashboard.master')
@section('title', "Edit X-ray (ID: $xray->id) for $p_f_name $p_l_name")
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <strong class="card-title fs-2">
                Edit X-ray (ID: <span class="text-primary fw-bold">{{ $xray->id }}</span>) for <span class="text-primary fw-bold">{{ $p_f_name . ' ' . $p_l_name }}</span>
            </strong>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form action="{{ route('x-rays.update', $xray->id) }}" class="forms-sample" method="POST" id="alert-form" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="text-center">
                        <p class="text-decoration-underline fw-bold h4 mb-2">Current X-ray Image</p>
                        <img src="{{ Storage::url($xray->image) }}" class="border border-dark border-5" width="300" alt="Image?">
                    </div>
                    @include('dashboard.x-rays.mass.form')
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

