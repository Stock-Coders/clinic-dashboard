@extends('layouts.dashboard.master')
@section('title', "Edit Treatment - (ID: $treatment->id) $treatment->procedure_name")
@section('content')
<div class="container-fluid">
    <p>
        @include('layouts.dashboard.includes.alert')
    </p>
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <strong class="card-title fs-2">
                Edit Treatment (ID: <span class="text-primary">{{ $treatment->id }}</span>) - Patient <span class="text-primary">{{ $treatment->procedure_name }}</span>
            </strong>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form action="{{ route('treatments.update', $treatment->id) }}" class="forms-sample" method="POST" id="alert-form">
                    @csrf
                    @method('PATCH')
                    @include('dashboard.treatments.form')
                    <button type="submit" class="btn btn-primary btn-md px-4 fs-8 shadow border-2 border-dark rounded me-2">Update</button>
                    <a href="{{ route('treatments.index') }}" class="btn btn-dark btn-md px-4 fs-8 shadow border-2 border-dark rounded">Return to Treatments</a>
                </form>
              </div> <!-- /.col -->
            </div>
          </div>
        </div> <!-- / .card -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
@endsection

