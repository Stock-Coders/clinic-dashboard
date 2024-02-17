@extends('layouts.dashboard.master')
@inject('xray', 'App\Models\XRay')
@section('title', 'Create X-ray')
@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
            <h4 class="card-title">Create X-ray</h4>
            <div class="col-sm-12 col-xl-12 xl-100">
                <div class="card-header pb-0">
                    <span><a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('x-rays.index') }}">X-rays</a> / Create X-ray</span>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <form action="{{route('x-rays.store')}}" class="forms-sample" method="POST" id="alert-form" enctype="multipart/form-data">
                            @csrf
                            @include('dashboard.x-rays.mass.form')
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
