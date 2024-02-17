@extends('layouts.dashboard.master')
@section('title') All Materials ({{ \App\Models\Material::count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Materials ({{ \App\Models\Material::count() }})</h5>
            {{-- <span>
                <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('materials.index') }}">Materials</a> / All Materials
            </span> --}}
            <div class="row">
                <div class="col-md-9">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / Materials
                </div>
                <div class="col-md-3">
                    <a href="{{ route('materials.create') }}" class="btn btn-success-gradien">Create New Material</a>
                </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    {{-- <th>Image</th> --}}
                    <th>Title</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Cost (EGP)</th>
                    <th>Expiration Date</th>
                    <th>Representative</th>
                    <th>Created by</th>
                    <th>Updated by</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th>Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                @foreach ($materials as $material)
                @php
                    $words = str_word_count($material->description, 2); // Get an associative array of words
                    $limitedWords = array_slice($words, 0, 4); // Limit to the first 4 words
                    $limitedDescription = implode(' ', $limitedWords) . (count($words) >= 4 ? '...' : ''); // Combine and add "..." if there are equal or more words
                @endphp
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    {{-- <td><img src="{{ Storage::url($material->image) }}" alt="—"></td> --}}
                    <td>{{ $material->title }}</td>
                    <td>{{ $material->description !== null ? $limitedDescription : '—' }}</td>
                    <td>{{ $material->quantity ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge rounded-pill badge-dark f-12">{{ $material->cost }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($material->expiration_date)->format('d-m-Y') }}</td>
                    <th>{{ $material->representative->name }}</th>
                    <th>{{ $material->create_user->username }}</th>
                    <th>{{ $material->update_user->username ?? '—' }}</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th>
                        <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('materials.edit', $material->id) }}"title="Edit ({{ $material->title }})">
                            <i class="fa fa-edit f-18"></i>
                        </a>
                        <form action="{{ route('materials.destroy', $material->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $material->title }})?');"title="{{"Delete ($material->title)"}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                        </form>
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
