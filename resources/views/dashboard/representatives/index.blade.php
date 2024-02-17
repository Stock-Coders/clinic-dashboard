@extends('layouts.dashboard.master')
@section('title') All Representatives ({{ \App\Models\Representative::count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>All Representatives ({{ \App\Models\Representative::count() }})</h5>
            {{-- <span>
                <a href="{{ route('dashboard') }}">Dashboard</a> / <a href="{{ route('representatives.index') }}">Representatives</a> / All Representatives
            </span> --}}
            <div class="row">
                <div class="col-md-9">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / Representatives
                </div>
                <div class="col-md-3">
                    <a href="{{ route('representatives.create') }}" class="btn btn-success-gradien">Create New Representative</a>
                </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Phone</th>
                    <th>Secondary Phone</th>
                    <th>Created by</th>
                    <th>Updated by</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($representatives as $representative)
                @php
                    $words = str_word_count($representative->description, 2); // Get an associative array of words
                    $limitedWords = array_slice($words, 0, 4); // Limit to the first 4 words
                    $limitedDescription = implode(' ', $limitedWords) . (count($words) >= 4 ? '...' : ''); // Combine and add "..." if there are equal or more words
                @endphp
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $representative->name }}</td>
                    <td>{{ $representative->description !== null ? $limitedDescription : '—' }}</td>
                    <td>{{ $representative->address ?? '—' }}</td>
                    <td>{{ $representative->email ?? '—' }}</td>
                    <td>{{ $representative->website ?? '—' }}</td>
                    <td>{{ $representative->phone }}</td>
                    <td>{{ $representative->secondary_phone ?? '—' }}</td>
                    <th>{{ $representative->create_user->username }}</th>
                    <th>{{ $representative->update_user->username ?? '—' }}</th>
                    <th>
                        <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('representatives.edit', $representative->id) }}"title="Edit ({{ $representative->name }})">
                            <i class="fa fa-edit f-18"></i>
                        </a>
                        <form action="{{ route('representatives.destroy', $representative->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $representative->name }})?');"title="{{"Delete ($representative->name)"}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                        </form>
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
