@extends('layouts.dashboard.master')
@if($user->id === auth()->user()->id)
    @section('title', "Change Your Password")
@else
    @section('title') Change Password | {{ $user->username }} @endsection
@endif
@section('content')
<div class="container-fluid">
    <p>@include('dashboard.users.change-password.changePasswordAlerts')</p>
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <strong class="card-title fs-2">
                @if($user->id === auth()->user()->id)
                    Change Your Password
                @else
                    Change Password (<span class="text-primary">{{ $user->username }}</span>)
                @endif
            </strong>
          </div>
          <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <form action="{{route('users.changePassword', $user->id)}}" class="forms-sample" method="post" id="alert-form">
                    @csrf
                    @method('PATCH')
                    @include('dashboard.users.change-password.changePasswordForm')
                    <input type="submit" value="Update" class="btn btn-primary border-info text-light me-2">
                    <input type="reset" value="Reset" class="btn btn-light">
                </form>
            </div>
        </div>
        </div> <!-- / .card -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
@endsection

@push('styles')
<style>
    #dot-eye-icon-old-password,
    #dot-eye-icon-new-password,
    #dot-eye-icon-confirm-new-password{
        cursor: pointer;
        font-size: 120%;
        padding-top: 10px;
        z-index: 100;
    }
</style>
@endpush

@push('scripts')
<script>
    function show_hide_old_password(){
        const old_password_input = document.querySelector("#old_password");
        const dot_eye            = document.querySelector("#dot-eye-icon-old-password");

        if(old_password_input.getAttribute('type') === "password"){
            old_password_input.setAttribute('type', 'text'); //also => old_password_input.type = "text"; (but not preferred!)
            if(dot_eye.classList.contains("fa-eye")){
                dot_eye.classList.remove("fa-eye");
            }
            dot_eye.classList.add("fa-eye-slash");
            dot_eye.style.color = "grey";
        }
        else{
            old_password_input.setAttribute('type', 'password'); //also => old_password_input.type = "password"; (but not preferred!)
            if(dot_eye.classList.contains("fa-eye-slash")){
                dot_eye.classList.remove("fa-eye-slash");
            }
            dot_eye.classList.add("fa-eye");
            dot_eye.style.color = "inherit";
        }
    }

    function show_hide_new_password(){
        const new_password_input = document.querySelector("#new_password");
        const dot_eye            = document.querySelector("#dot-eye-icon-new-password");

        if(new_password_input.getAttribute('type') === "password"){
            new_password_input.setAttribute('type', 'text'); //also => new_password_input.type = "text"; (but not preferred!)
            if(dot_eye.classList.contains("fa-eye")){
                dot_eye.classList.remove("fa-eye");
            }
            dot_eye.classList.add("fa-eye-slash");
            dot_eye.style.color = "grey";
        }
        else{
            new_password_input.setAttribute('type', 'password'); //also => new_password_input.type = "password"; (but not preferred!)
            if(dot_eye.classList.contains("fa-eye-slash")){
                dot_eye.classList.remove("fa-eye-slash");
            }
            dot_eye.classList.add("fa-eye");
            dot_eye.style.color = "inherit";
        }
    }

    function show_hide_confirm_new_password(){
        const confirm_new_password_input = document.querySelector("#confirm_new_password");
        const dot_eye                    = document.querySelector("#dot-eye-icon-confirm-new-password");

        if(confirm_new_password_input.getAttribute('type') === "password"){
            confirm_new_password_input.setAttribute('type', 'text'); //also => confirm_new_password_input.type = "text"; (but not preferred!)
            if(dot_eye.classList.contains("fa-eye")){
                dot_eye.classList.remove("fa-eye");
            }
            dot_eye.classList.add("fa-eye-slash");
            dot_eye.style.color = "grey";
        }
        else{
            confirm_new_password_input.setAttribute('type', 'password'); //also => confirm_new_password_input.type = "password"; (but not preferred!)
            if(dot_eye.classList.contains("fa-eye-slash")){
                dot_eye.classList.remove("fa-eye-slash");
            }
            dot_eye.classList.add("fa-eye");
            dot_eye.style.color = "inherit";
        }
    }
</script>
@endpush


