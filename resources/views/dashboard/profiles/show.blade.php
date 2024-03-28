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
                            <div class="avatar-container text-center mb-4 py-5 rounded">
                                <p class="text-decoration-underline text-light fw-bold h5 mb-2">Current Avatar</p>
                                {{-- @php
                                    $imageExists = Storage::exists($user->profile->avatar);
                                @endphp --}}
                                <img src="{{ Storage::url($user->profile->avatar) }}" class="avatar-image border border-dark border-5" width="300" alt="Image">
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

@push('styles')
<style>
.avatar-container {
    margin: auto;
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    overflow: auto;
    background: linear-gradient(315deg, rgba(101,0,94,1) 3%, rgba(60,132,206,1) 38%, rgba(48,238,226,1) 68%, rgba(255,25,25,1) 98%);
    animation: gradient 8s ease infinite;
    background-size: 400% 400%;
    background-attachment: fixed;
}

/* @keyframes gradient {
    0% {
        background-position: 0% 0%;
    }
    50% {
        background-position: 100% 100%;
    }
    100% {
        background-position: 0% 0%;
    }
} */
</style>
@endpush

@push('scripts')
<!-- JavaScript for Popup Modal -->
<script>
    // Get the modal
    document.addEventListener('DOMContentLoaded', function() {
    var modalBg = document.querySelector('.modal-bg');
    var avatarImage = document.querySelector('.avatar-image');
    var closeBtn = document.querySelector('.close-btn');

    avatarImage.addEventListener('click', function() {
            modalBg.style.display = 'block';
        });

        closeBtn.addEventListener('click', function() {
            modalBg.style.display = 'none';
        });
    });
</script>
@endpush
