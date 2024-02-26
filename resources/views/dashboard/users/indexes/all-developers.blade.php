@extends('layouts.dashboard.master')
@section('title') All Developers ({{ \App\Models\User::ofType('developer')->count() }}) @endsection
@section('content')
<div class="container-fluid">
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Developers ({{ \App\Models\User::ofType('developer')->count() }})</h5>
            {{-- <span>
                <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('users.UsersIndex') }}">Users</a> / All Developers
            </span> --}}
            <div class="row">
                <div class="col-md-9">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('users.UsersIndex') }}">Users</a> / All Developers
                </div>
                @if(auth()->user()->user_type != "employee")
                <div class="col-md-3">
                    <a href="{{ route('users.create') }}" class="btn btn-success-gradien">Create New User</a>
                </div>
                @endif
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    {{-- <th>ID</th> --}}
                    <th>Avatar</th>
                    <th>Username</th>
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
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($developers as $developer)
                  <tr>
                    <th style="@if($developer->email === "doctor1@gmail.com" || $developer->email === "doctor2@gmail.com") background-color:beige; @endif">
                        {{ $loop->iteration }}
                    </th>
                    {{-- <td>{{ $developer->id }}</td> --}}
                    <td>
                        @if(isset($developer->profile->avatar))
                        <img src="{{ Storage::url($developer->profile->avatar) }}" width="70">
                        @else
                        —
                        @endif
                    </td>
                    <td>
                        @if($developer->id === auth()->user()->id)
                            <a class="text-decoration-underline fw-bold" href="{{ route('authUserProfileView', $developer->username) }}" target="_blank">{{ $developer->username }}</a> (Profile)
                        @else
                            {{ $developer->username }}
                        @endif
                    </td>
                    <td>{{ $developer->email }}</td>
                    {{-- <td class="text-center">
                        @if ($developer->email_verified_at !== null)
                            <span class="badge rounded-pill bg-success text-center fw-bold f-12">Yes <i class="fa fa-check-circle f-12"></i></span>
                        @else
                            <span class="badge rounded-pill bg-danger text-center fw-bold f-12">No <i class="fa fa-times-circle f-12"></i></span>
                        @endif
                    </td> --}}
                    <td>{{ $developer->phone }}</td>
                    @if($developer->email === "doctor1@gmail.com" || $developer->email === "doctor2@gmail.com")
                    <td style="background-color:beige; font-weight:bold;">
                        {{ ucfirst($developer->user_type) }} <span class="text-success">(Master)</span>
                    </td>
                    @else
                    <td>{{ ucfirst($developer->user_type) }}</td>
                    @endif
                    <td>{{ $developer->user_role === null ? '—' : ucfirst($developer->user_role) }}</td>
                    <td class="text-center">
                        <span class="
                        @if ($developer->account_status === "active") badge bg-success text-light
                        @elseif($developer->account_status === "suspended") badge bg-warning text-dark
                        @else($developer->account_status === "deactivated") badge bg-info text-light
                        @endif fw-bold text-center f-12">
                            {{ ucfirst($developer->account_status) }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($developer->registration_datetime)->tz('Africa/Cairo')->format('d-m-Y h:i A')  }}</td>
                    <td>{{ \Carbon\Carbon::parse($developer->last_login_datetime)->tz('Africa/Cairo')->format('d-m-Y h:i A') ?? '—' }}</td>
                    <td>{{ $developer->last_login_ip ?? '—' }}</td>
                    <td>{{ $developer->create_user->username ?? '—' }}</td>
                    <td>{{ $developer->update_user->username ?? '—' }}</td>
                    {{-- <td><a class="btn btn-secondary btn-md px-2" href="javascript:void(0)" target="_blank">Show</a></td> --}}
                    <th style="@if($developer->user_type === "developer" && auth()->user()->id !== $developer->id && auth()->user()->user_type === "developer") background-color:rgb(255, 204, 153); @endif">
                        @if((auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
                        auth()->user()->email === "codexsoftwareservices01@gmail.com") && auth()->user()->id !== $developer->id && $developer->user_type === "developer" &&
                        auth()->user()->user_type === "developer")
                            <div class="d-flex justify-content-center">
                                <span class="text-center text-dark fw-bold fs-6"><i class="fa fa-lock f-30"></i></span> {{-- Unauthorized Action for developers --}}
                            </div>
                        @else
                            <div class="d-flex @if(auth()->user()->id === $developer->id) justify-content-center @else justify-content-between @endif">
                                <a class="@if(auth()->user()->id === $developer->id) btn btn-dark @else btn btn-primary @endif btn-md m-1 px-3" href="{{ route('users.edit', $developer->id) }}" @if(auth()->user()->id === $developer->id) title="Edit your data" title="{{ 'Edit ('.$developer->username.')'}}" @endif>
                                    @if(auth()->user()->id === $developer->id)<i class="fa fa-user f-28" aria-hidden="true"></i>@endif
                                    <i class="fa fa-edit f-18"></i>
                                </a>
                                @if (auth()->user()->id !== $developer->id)
                                    <form action="{{ route('users.destroy', $developer->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $developer->username }})?');" title="{{"Delete ($developer->username)"}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </th>
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
