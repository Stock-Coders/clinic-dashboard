@extends('layouts.dashboard.master')
@section('title') All Employees ({{ \App\Models\User::ofType('employee')->count() }}) @endsection
@section('content')
<div class="container-fluid">
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Employees ({{ \App\Models\User::ofType('employee')->count() }})</h5>
            {{-- <span>
                <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('users.UsersIndex') }}">Users</a> / All Employees
            </span> --}}
            <div class="row">
                <div class="col-md-9">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('users.UsersIndex') }}">Users</a> / All Employees
                </div>
                <div class="col-md-3">
                    <a href="{{ route('users.create') }}" class="btn btn-success-gradien">Create New User</a>
                </div>
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
                  @foreach ($employees as $employee)
                  <tr>
                    <th style="@if($employee->email === "doctor1@gmail.com" || $employee->email === "doctor2@gmail.com") background-color:beige; @endif">
                        {{ $loop->iteration }}
                    </th>
                    {{-- <td>{{ $employee->id }}</td> --}}
                    <td>
                        @if(isset($employee->profile->avatar))
                        <img src="{{ Storage::url($employee->profile->avatar) }}" width="70">
                        @else
                        —
                        @endif
                    </td>
                    <td>
                        @if(in_array($authUserEmail, $developersEmails))
                            <a class="text-decoration-underline fw-bold" href="{{ route('authUserProfileView', $employee->username) }}" target="_blank">{{ $employee->username }}</a>
                        @elseif($employee->id === auth()->user()->id)
                            <a class="text-decoration-underline fw-bold" href="{{ route('authUserProfileView', $employee->username) }}" target="_blank">{{ $employee->username }}</a> (Profile)
                        @else
                            {{ $employee->username }}
                        @endif
                    </td>
                    <td>{{ $employee->email }}</td>
                    {{-- <td class="text-center">
                        @if ($employee->email_verified_at !== null)
                            <span class="badge rounded-pill bg-success text-center fw-bold f-12">Yes <i class="fa fa-check-circle f-12"></i></span>
                        @else
                            <span class="badge rounded-pill bg-danger text-center fw-bold f-12">No <i class="fa fa-times-circle f-12"></i></span>
                        @endif
                    </td> --}}
                    <td>{{ $employee->phone }}</td>
                    <td>{{ ucfirst($employee->user_type) }}</td>
                    <td>{{ $employee->user_role === null ? '—' : ucfirst($employee->user_role) }}</td>
                    <td class="text-center">
                        <span class="
                        @if ($employee->account_status === "active") badge bg-success text-light
                        @elseif($employee->account_status === "suspended") badge bg-warning text-dark
                        @else($employee->account_status === "deactivated") badge bg-info text-light
                        @endif fw-bold text-center f-12">
                            {{ ucfirst($employee->account_status) }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($employee->registration_datetime)->tz('Africa/Cairo')->format('d-m-Y h:i A')  }}</td>
                    <td>{{ \Carbon\Carbon::parse($employee->last_login_datetime)->tz('Africa/Cairo')->format('d-m-Y h:i A') ?? '—' }}</td>
                    <td>{{ $employee->last_login_ip ?? '—' }}</td>
                    <td>{{ $employee->create_user->username ?? '—' }}</td>
                    <td>{{ $employee->update_user->username ?? '—' }}</td>
                    {{-- <td><a class="btn btn-secondary btn-md px-2" href="javascript:void(0)" target="_blank">Show</a></td> --}}
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                        <th>
                            <div class="d-flex @if(auth()->user()->id === $employee->id) justify-content-center @else justify-content-between @endif">
                                <a class="@if(auth()->user()->id === $employee->id) btn btn-dark @else btn btn-primary @endif btn-md m-1 px-3" href="{{ route('users.edit', $employee->id) }}" @if(auth()->user()->id === $employee->id) title="Edit your data" title="{{ 'Edit ('.$employee->username.')'}}" @endif>
                                    @if(auth()->user()->id === $employee->id)<i class="fa fa-user f-28" aria-hidden="true"></i>@endif
                                    <i class="fa fa-edit f-18"></i>
                                </a>
                                @if (auth()->user()->id !== $employee->id)
                                    <form action="{{ route('users.destroy', $employee->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $employee->username }})?');" title="{{"Delete ($employee->username)"}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                                    </form>
                                @endif
                            </div>
                        </th>
                    @endif
                    @if(auth()->user()->user_type === "employee" || auth()->user()->user_type === "doctor" && (auth()->user()->email !== "doctor1@gmail.com" && auth()->user()->email !== "doctor2@gmail.com"))
                    <th>
                        <div class="d-flex justify-content-center">
                            @if(auth()->user()->id === $employee->id)
                            <a class="btn btn-dark btn-md m-1 px-3" href="{{ route('users.edit', $employee->id) }}" title="Edit your data">
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
