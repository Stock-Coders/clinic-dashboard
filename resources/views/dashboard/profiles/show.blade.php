@extends('layouts.dashboard.master')
@section('title', "Profile | $user->username")
@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
    <p>
        @include('layouts.dashboard.includes.alert')
        @if(session()->has('error_secondary_phone'))
        <div class="alert alert-danger text-center w-75 mx-auto">
            {{ session()->get('error_secondary_phone') }} <span class="fw-bold">You can check the primary phone number from <a class="text-light text-decoration-underline" href="{{ route('users.edit', $user->id) }}" target="_blank">here</a>.</span>
        </div>
        @endif
    </p>
      <div class="card-body">
            <h4 class="card-title">
                {{-- For specific users only the creators (developers) --}}
                @if($user->id === auth()->user()->id)
                    Your Profile
                @else
                    <span class="text-primary">{{ $user->username }}</span>'s Profile <span class="h6">(<span class="text-muted">{{ ucfirst($user->user_type) }}</span>)</span>
                @endif
            </h4>
            <div class="col-sm-12 col-xl-12 xl-100">
                <div class="card-header pb-0">
                    <span><a href="{{ route('dashboard') }}">Dashboard</a> / @if($user->id === auth()->user()->id) Your Profile @else Profiles / {{ $user->username }} @endif</span>
                </div>
                {{-- <div class="card-header pb-0">
                    <h5>Add New Profile</h5>
                </div> --}}
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <form action="{{ route('profile.storeOrUpdate') }}" class="forms-sample" method="POST" id="alert-form" enctype="multipart/form-data">
                            @csrf
                            @if(isset($user->profile->avatar))
                            <div class="text-left mb-4">
                                <p class="text-decoration-underline fw-bold h5 mb-2">Current Avatar</p>
                                <img src="{{ Storage::url($user->profile->avatar) }}" class="border border-dark border-5" width="250" alt="Image?">
                            </div>
                            @endif
                            @include('dashboard.profiles.form')
                            <input type="submit" value="Save" class="btn btn-success btn-md px-4 fs-8 shadow border-2 border-dark rounded me-2">
                            <input type="reset" value="Reset" class="btn btn-light btn-md px-4 fs-8 shadow border-2 border-dark rounded">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
