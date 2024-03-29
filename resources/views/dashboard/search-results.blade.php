@extends('layouts.dashboard.master')
@section('title') Results "{{ $searchQuery }}" ({{ $mergedResults->count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>Results - <span class="bade badge-dark text-light px-1 py-0 rounded">{{ $searchQuery }}</span> ({{ $mergedResults->count() }})</h5>
            {{-- <span>
                <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('analyses.index') }}">Analyses</a> / Results
            </span> --}}
            <div class="row">
                <div class="col-md-9">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / Search Results
                </div>
                {{-- <div class="col-md-3">
                    <a href="javascript:void(0)" class="btn btn-success-gradien">Create New ....</a>
                </div> --}}
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th class="text-center">ID</th>
                    <th class="text-center">Subject (Title/Name)</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Reference (Entity)</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th class="text-center">Action</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($mergedResults as $result)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $result->id }}</td>
                    <td>
                        @if($result->getTable() == "users")
                            {{ $result->username }}
                            (<span class="fw-bold text-primary">{{ $result->email }}</span>)
                            <br/>
                            @if($result->user_role != null)
                                (<span class="fw-bold text-danger">{{ ucfirst($result->user_type) }}</span> &rightarrow; <span class="fw-bold text-secondary">{{ ucfirst($result->user_role) }}</span>)
                            @else
                                (<span class="fw-bold text-danger">{{ ucfirst($result->user_type) }}</span>)
                            @endif
                        @elseif($result->getTable() == "patients")
                            <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', [$result->id, $result->first_name]) }}" target="_blank">
                                {{ $result->first_name .' '. $result->last_name }}
                            </a>
                        @elseif($result->getTable() == "xrays")
                            <a class="text-decoration-underline fw-bold" href="{{ route('x-rays.show', $result->id) }}" target="_blank">{{ $result->timing == "in_between" ? "In Between" : ucfirst($result->timing) }}</a>
                            (<a class="text-decoration-underline fw-bold text-secondary" href="{{ route('patients.show', [$result->patient_id, $result->patient->first_name]) }}" target="_blank">{{ $result->patient->first_name .' '. $result->patient->last_name }}</a>)
                        @elseif($result->getTable() == "representatives")
                            {{ $result->name }}
                            @if($result->email != null)
                            (<span class="fw-bold text-primary">{{ $result->email }}</span>)
                            @endif
                        @elseif($result->getTable() == "materials")
                            {{ $result->title }}
                        @endif
                    </td>
                    <td class="image-td text-center">
                        @if($result->getTable() == "users")
                            @if(isset($result->profile->avatar))
                            <img src="{{ Storage::url($result->profile->avatar) }}" class="@if(!Storage::exists($result->profile->avatar)) bg-warning p-2 rounded text-center text-dark @endif" alt="Image not found." width="80">
                            @else
                            {{-- No Image. --}}
                            —
                            @endif
                        @elseif($result->getTable() == "patients")
                        <img src="{{ Storage::url($result->image) }}" alt="—" width="80">
                        @elseif($result->getTable() == "xrays")
                        <img src="{{ Storage::url($result->image) }}" alt="—" width="80">
                        @else
                        —
                        @endif
                    </td>
                    <th>
                        @if($result->getTable() == "users")
                            <a href="{{ route('users.UsersIndex') }}" class="text-decoration-underline fw-bold" target="_blank">
                                {{ ucfirst($result->getTable()) }}
                            </a>
                        @elseif($result->getTable() == "patients")
                            <a href="{{ route('patients.index') }}" class="text-decoration-underline fw-bold" target="_blank">
                                {{ ucfirst($result->getTable()) }}
                            </a>
                        @elseif($result->getTable() == "xrays")
                            <a href="{{ route('x-rays.index') }}" class="text-decoration-underline fw-bold" target="_blank">
                                X-rays
                            </a>
                        @elseif($result->getTable() == "representatives")
                            <a href="{{ route('representatives.index') }}" class="text-decoration-underline fw-bold" target="_blank">
                                {{ ucfirst($result->getTable()) }}
                            </a>
                        @elseif($result->getTable() == "materials")
                            <a href="{{ route('materials.index') }}" class="text-decoration-underline fw-bold" target="_blank">
                                {{ ucfirst($result->getTable()) }}
                            </a>
                        @endif
                    </th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th class="w-25" style="@if(auth()->user()->user_type == "developer" && $result->id != auth()->user()->id && $result->user_type == "developer") background-color: rgb(255, 204, 153); @endif">
                        <div class="d-flex justify-content-center">
                            @if($result->getTable() == "users")
                                @if(auth()->user()->user_type == "developer" && $result->user_type != "developer")
                                    <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('users.edit', $result->id) }}"title="Edit ({{ $result->username }})">
                                        <i class="fa fa-edit f-18"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $result->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $result->username }}) user?');"title="Delete (<?php echo $result->username; ?>)" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                                    </form>
                                @elseif(auth()->user()->user_type == "developer" && auth()->user()->id == $result->id)
                                    <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('users.edit', $result->id) }}"title="Edit ({{ $result->username }})">
                                        <i class="fa fa-edit f-18"></i>
                                    </a>
                                @else
                                    <div class="d-flex justify-content-center">
                                        <span class="text-center text-dark fw-bold fs-6"><i class="fa fa-lock f-30"></i></span> {{-- Unauthorized Action (A) for doctors (masters) --}}
                                    </div>
                                @endif
                            @elseif($result->getTable() == "patients")
                                <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('patients.show', $result->id) }}">
                                    <i class="icofont icofont-open-eye f-24"></i>
                                </a>
                                <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('patients.edit', $result->id) }}">
                                    <i class="fa fa-edit f-18"></i>
                                </a>
                                <form action="{{ route('patients.destroy', $result->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $result->first_name . ' '. $result->last_name }})\'s patient?');"title="Delete (<?php echo $result->first_name . ' ' . $result->last_name; ?>)" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                                </form>
                            @elseif($result->getTable() == "xrays")
                                <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('x-rays.show', $result->id) }}">
                                    <i class="icofont icofont-open-eye f-24"></i>
                                </a>
                                <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('x-rays.edit', $result->id) }}">
                                    <i class="fa fa-edit f-18"></i>
                                </a>
                                <form action="{{ route('x-rays.destroy', $result->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $result->patient->first_name . ' '. $result->patient->last_name }})\'s X-ray?');"title="Delete (<?php echo $result->patient->first_name.'\'s X-ray'; ?>)" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                                </form>
                            @elseif($result->getTable() == "representatives")
                                <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('representatives.edit', $result->id) }}">
                                    <i class="fa fa-edit f-18"></i>
                                </a>
                                <form action="{{ route('representatives.destroy', $result->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $result->name }})\'s representative?');"title="Delete (<?php echo $result->name; ?>)" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                                </form>
                            @elseif($result->getTable() == "materials")
                                {{-- <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('materials.show', $result->id) }}">
                                    <i class="icofont icofont-open-eye f-24"></i>
                                </a> --}}
                                <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('materials.edit', $result->id) }}">
                                    <i class="fa fa-edit f-18"></i>
                                </a>
                                <form action="{{ route('materials.destroy', $result->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $result->title }})\'s material?');"title="Delete (<?php echo $result->title; ?>)" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                                </form>
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
<style>
    .image-td {
        width: 20%;
    }
</style>
@endpush

@push('scripts')
<!-- Plugins JS start-->
<script src="{{ asset('/assets/dashboard/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/dashboard/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('/assets/dashboard/js/tooltip-init.js') }}"></script>
<!-- Plugins JS Ends-->
@endpush
