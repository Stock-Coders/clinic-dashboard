@extends('layouts.dashboard.master')
@if($user->id === auth()->user()->id)
    @section('title', "Edit Your Data")
@else
    @section('title', "Edit User ($user->username)")
@endif
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <strong class="card-title fs-2">
                @if($user->id === auth()->user()->id)
                    Edit Your Data
                @else
                    Edit User (<span class="text-primary">{{ $user->username }}</span>)
                @endif
            </strong>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form action="{{ route('users.update', $user->id) }}" class="forms-sample" method="POST" id="alert-form">
                    @csrf
                    @method('PATCH')
                    @include('dashboard.users.form')
                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary btn-md px-4 fs-8 shadow border-2 border-dark rounded me-2">Update</button>
                        <a href="{{ route('users.UsersIndex') }}" class="btn btn-dark btn-md px-4 fs-8 shadow border-2 border-dark rounded me-2">Return to Users</a>
                        <a href="{{ route('users.changePassword', $user->username) }}" class="btn btn-warning btn-md px-4 fs-8 shadow border-2 border-dark rounded">Want to change password?</a>
                    </div>
                </form>
              </div> <!-- /.col -->
            </div>
          </div>
        </div> <!-- / .card -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
@endsection

