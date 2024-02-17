@extends('layouts.dashboard.master')
@inject('prescription', 'App\Models\Prescription')
@section('title', 'Create Prescription')
@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
            <h4 class="card-title">Create Prescription</h4>
            <div class="col-sm-12 col-xl-12 xl-100">
                <div class="card-header pb-0">
                    <span><a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('prescriptions.index') }}">Prescriptions</a> / Create Prescription</span>
                </div>
                {{-- <div class="card-header pb-0">
                    <h5>Add New Prescription</h5>
                </div> --}}
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <form action="{{route('prescriptions.store')}}" class="forms-sample" method="POST" id="alert-form">
                            @csrf
                            @include('dashboard.prescriptions.form')
                            <input type="submit" value="Add" class="btn btn-success btn-md px-4 fs-8 shadow border-2 border-dark rounded me-2">
                            <input type="reset" value="Reset" class="btn btn-light btn-md px-4 fs-8 shadow border-2 border-dark rounded">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
