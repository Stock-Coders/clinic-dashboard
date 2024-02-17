@extends('layouts.dashboard.master')
@inject('payment', 'App\Models\Payment')
@section('title', 'Create Payment')
@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">
            <h4 class="card-title">Create Payment</h4>
            <div class="col-sm-12 col-xl-12 xl-100">
                <div class="card-header pb-0">
                    <span><a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('payments.index') }}">Payments</a> / Create Payment</span>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <form action="{{route('payments.store')}}" class="forms-sample" method="POST" id="alert-form">
                            @csrf
                            @include('dashboard.payments.form')
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
