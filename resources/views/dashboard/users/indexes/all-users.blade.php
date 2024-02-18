@extends('layouts.dashboard.master')
@section('title') All Users ({{ $users->count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Users ({{ $users->count() }})</h5>
            {{-- <span>
                <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('users.UsersIndex') }}">Users</a> / All Users
            </span> --}}
            <div class="row">
                <div class="col-md-9">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('users.UsersIndex') }}">Users</a> / All Users
                </div>
                @if(auth()->user()->user_type != "employee")
                <div class="col-md-3">
                    <a href="{{ route('users.create') }}" class="btn btn-success-gradien">Create New User</a>
                </div>
                @endif
            </div>
          </div>
          <div class="card-body">
            {{-- <p>@include('layouts.dashboard.includes.alert')</p> --}}
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    {{-- <th>ID</th> --}}
                    <th>Avatar</th>
                    <th>Username @if(in_array($authUserEmail, $developersEmails)) (Profile) @endif</th>
                    <th>Email</th>
                    {{-- <th>Email Veified?</th> --}}
                    <th>Phone</th>
                    <th>User Type</th>
                    <th>User Role</th>
                    <th>Account Status</th>
                    <th>Registration Date/Time</th>
                    <th>Last Login Date/Time</th>
                    <th>Last Login IP</th>
                    <th>Created by</th>
                    <th>Updated by</th>
                    {{-- <th>More..</th> --}}
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th>Edit / Delete</th>
                    @endif
                    @if(auth()->user()->user_type === "employee" || auth()->user()->user_type === "doctor" && (auth()->user()->email !== "doctor1@gmail.com" && auth()->user()->email !== "doctor2@gmail.com"))
                    <th>Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                  <tr>
                    <th style="@if($user->email === 'doctor1@gmail.com' || $user->email === 'doctor2@gmail.com') color: black; background-color:beige; @elseif($user->user_type === 'developer') color: black; background-color: #3bbaff; @endif">
                        {{ $loop->iteration }}
                    </th>
                    {{-- <td>{{ $user->id }}</td> --}}
                    <td>
                        @if(isset($user->profile->avatar))
                        <img src="{{ Storage::url($user->profile->avatar) }}" width="70">
                        @else
                        —
                        @endif
                    </td>
                    <td>
                        @if(in_array($authUserEmail, $developersEmails) && !in_array($user->email, $developersEmails))
                            <a class="text-decoration-underline fw-bold" href="{{ route('authUserProfileView', $user->username) }}" target="_blank">{{ $user->username }}</a>
                        @elseif($user->id === auth()->user()->id && !in_array($user->email, $developersEmails))
                            <a class="text-decoration-underline fw-bold" href="{{ route('authUserProfileView', $user->username) }}" target="_blank">{{ $user->username }}</a> (Profile)
                        @elseif($user->id === auth()->user()->id && in_array($user->email, $developersEmails))
                            <a class="text-decoration-underline fw-bold" href="{{ route('authUserProfileView', $user->username) }}" target="_blank">{{ $user->username }}</a>
                        @else
                            {{ $user->username }}
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    {{-- <td class="text-center">
                        @if ($user->email_verified_at !== null)
                            <span class="badge rounded-pill bg-success text-center fw-bold f-12">Yes <i class="fa fa-check-circle f-12"></i></span>
                        @else
                            <span class="badge rounded-pill bg-danger text-center fw-bold f-12">No <i class="fa fa-times-circle f-12"></i></span>
                        @endif
                    </td> --}}
                    <td>{{ $user->phone }}</td>
                    @if($user->email === "doctor1@gmail.com" || $user->email === "doctor2@gmail.com")
                    <td style="background-color:beige; font-weight:bold;">
                        <span class="text-dark">{{ ucfirst($user->user_type) }}</span> <span class="text-success">(Master)</span>
                    </td>
                    @else
                    <td>{{ ucfirst($user->user_type) }}</td>
                    @endif
                    <td>{{ $user->user_role === null ? '—' : ucfirst($user->user_role) }}</td>
                    <td class="text-center">
                        <span class="
                        @if ($user->account_status === "active") badge bg-success text-light
                        @elseif($user->account_status === "suspended") badge bg-warning text-dark
                        @else($user->account_status === "deactivated") badge bg-info text-light
                        @endif fw-bold text-center f-12">
                            {{ ucfirst($user->account_status) }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($user->registration_datetime)->tz('Africa/Cairo')->format('d-m-Y h:i A')  }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->last_login_datetime)->tz('Africa/Cairo')->format('d-m-Y h:i A') ?? '—' }}</td>
                    <td>{{ $user->last_login_ip ?? '—' }}</td>
                    <td>{{ $user->create_user->username ?? '—' }}</td>
                    <td>{{ $user->update_user->username ?? '—' }}</td>
                    {{-- <td><a class="btn btn-secondary btn-md px-2" href="javascript:void(0)">Show</a></td> --}}
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                        <th style="@if((($user->email === "doctor1@gmail.com" || $user->email === "doctor2@gmail.com") && auth()->user()->id !== $user->id && auth()->user()->user_type === "doctor") ||
                        ($user->user_type === "developer" && auth()->user()->id !== $user->id && auth()->user()->user_type === "developer")) background-color:rgb(255, 204, 153); @endif">
                            @if(($user->email === "doctor1@gmail.com" || $user->email === "doctor2@gmail.com") && auth()->user()->id !== $user->id &&
                            (auth()->user()->email !== "kareemtarekpk@gmail.com" && auth()->user()->email !== "mr.hatab055@gmail.com" &&
                            auth()->user()->email !== "stockcoders99@gmail.com"))
                                <div class="d-flex justify-content-center">
                                    <span class="text-center text-dark fw-bold fs-6"><i class="fa fa-lock f-30"></i></span> {{-- Unauthorized Action (A) for doctors (masters) --}}
                                </div>
                            @elseif((auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                            auth()->user()->email === "stockcoders99@gmail.com") && auth()->user()->id !== $user->id && $user->user_type === "developer" &&
                            auth()->user()->user_type === "developer")
                                <div class="d-flex justify-content-center">
                                    <span class="text-center text-dark fw-bold fs-6"><i class="fa fa-lock f-30"></i></span> {{-- Unauthorized Action (B) for developers --}}
                                </div>
                            @else
                                <div class="d-flex @if(auth()->user()->id === $user->id) justify-content-center @else justify-content-between @endif">
                                    <a class="@if(auth()->user()->id === $user->id) btn btn-dark @else btn btn-primary @endif btn-md m-1 px-3" href="{{ route('users.edit', $user->id) }}" @if(auth()->user()->id === $user->id) title="Edit your data" title="{{ 'Edit ('.$user->username.')'}}" @endif>
                                        @if(auth()->user()->id === $user->id)<i class="fa fa-user f-28" aria-hidden="true"></i>@endif
                                        <i class="fa fa-edit f-18"></i>
                                    </a>
                                    @if (auth()->user()->id !== $user->id)
                                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $user->username }})?');" title="{{"Delete ($user->username)"}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </th>
                    @endif
                    @if(auth()->user()->user_type === "employee" || auth()->user()->user_type === "doctor" && (auth()->user()->email !== "doctor1@gmail.com" && auth()->user()->email !== "doctor2@gmail.com"))
                    <th>
                        <div class="d-flex justify-content-center">
                            @if(auth()->user()->id === $user->id)
                            <a class="btn btn-dark btn-md m-1 px-3" href="{{ route('users.edit', $user->id) }}" title="Edit your data">
                                <i class="fa fa-user f-28" aria-hidden="true"></i><i class="fa fa-edit f-18"></i>
                            </a>
                            @else
                                —
                            @endif
                        </div>
                    </th>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Zero Configuration  Ends-->
    </div>
  </div>
@endsection

@push('styles')
<!-- Plugins css start-->
<link rel="stylesheet" type="text/css" href="{{ asset('/assets/dashboard/css/datatables.css') }}">
@endpush

@push('scripts')
<!-- Plugins JS start-->
<script src="{{ asset('/assets/dashboard/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/dashboard/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('/assets/dashboard/js/tooltip-init.js') }}"></script>
<!-- Plugins JS Ends-->
@endpush
