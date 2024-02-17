@extends('layouts.dashboard.master')
@section('title') X-rays | {{ $patient->first_name . ' ' . $patient->last_name }} @endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header">
            <div class="mb-4 text-center">
                <h1 class="text-decoration-underline">Patient's X-ray Gallery</h1>
            </div>
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    Add Last Visit For&nbsp;<span class="text-success fw-bold">{{ $patient->first_name }}</span>?
                    <a href="{{ route('patients.lastVisitsCreate', $patient->id) }}"><i class="icofont icofont-meeting-add text-success f-60"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
                <div class="d-flex align-items-center">
                    Add X-ray For&nbsp;<span class="text-warning fw-bold">{{ $patient->first_name }}</span>?
                    <a href="{{ route('patient.x-rays.create', $patient->id) }}"><i class="icofont icofont-tooth text-warning f-40"></i><i class="icon-hand-point-up f-16"></i></a>
                </div>
            </div>
            <strong class="card-title">
                <p class="fs-5"><span class="text-decoration-underline">No. of X-rays:</span> <span class="badge rounded-pill badge-info">{{ $combinedXRaysTiming->count() }}</span></p>
                <p class="fs-5"><span class="text-decoration-underline">Patient ID:</span> <span class="badge rounded-pill badge-dark">{{ $patient->id }}</span></p>
                <p class="fs-5"><span class="text-decoration-underline">Patient Full Name:</span> <span style="background-color: rgb(235, 235, 235);" class="text-dark fw-bold p-1 rounded">{{ $patient->first_name .' '. $patient->last_name }}</span></p>
            </strong>
            <div class="d-flex justify-content-center">
                <img src='{{asset("/assets/dashboard/images/custom-images/patients/images/$patient->image")}}' alt="Patient Image?" width="300" loading="lazy">
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                {{-- Start - Container-fluid --}}
                <div class="container-fluid">
                    <div class="d-flex justify-content-start mb-1">
                        <div>
                            <a class="text-primary fw-bold text-decoration-underline" href="{{ route('patient.x-rays.index', $patient->id) }}">Click here</a> to see all the <span class="fw-bold">X-rays</span> of the current patient.
                        </div>
                    </div>
                    <div class="card">
                        <div class="row product-page-main">
                            <div class="col-sm-12">
                                <ul class="nav nav-tabs border-tab mb-0" id="top-tab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">All ({{ $combinedXRaysTiming->count() }})</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="before-tab" data-bs-toggle="tab" href="#before" role="tab" aria-controls="before" aria-selected="false">Before ({{ $patientXRaysBefore->count() }})</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="in-between-tab" data-bs-toggle="tab" href="#in-between" role="tab" aria-controls="in-between" aria-selected="false">In Between ({{ $patientXRaysInBetween->count() }})</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="after-tab" data-bs-toggle="tab" href="#after" role="tab" aria-controls="after" aria-selected="true">After ({{ $patientXRaysAfter->count() }})</a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>
                                <div class="tab-content" id="top-tabContent">
                                    <!-- Popup Modal -->
                                    <div id="xrayModal" class="modal">
                                        <span class="close">&times;</span>
                                        <img class="modal-content" id="modalImage">
                                    </div>
                                    <div class="d-flex justify-content-center mt-3 mb-2">
                                        <div class="alert alert-primary w-50 text-center text-dark rounded-pill" style="background-color: rgb(161, 203, 255);">
                                            <span class="fw-bold">Please click on the image(s) to view in a larger popup.</span>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade active show" id="all" role="tabpanel" aria-labelledby="all-tab">
                                        <p class="mb-0 m-t-20">
                                            @forelse($combinedXRaysTiming as $allXRay)
                                                @php
                                                    $imagePath   = Storage::url($allXRay->image);
                                                    $imageExists = Storage::exists($allXRay->image);
                                                @endphp
                                                <img src="{{ Storage::url($allXRay->image) }}" alt="Image?" width="200" class="@if($imageExists) xray-image @endif mx-2" @if($imageExists) data-image="{{ Storage::url($allXRay->image) }}" @endif>
                                            @empty
                                                No X-rays yet.
                                            @endforelse
                                        </p>
                                    </div>
                                    <div class="tab-pane fade" id="before" role="tabpanel" aria-labelledby="before-tab">
                                        <p class="mb-0 m-t-20">
                                            @forelse($patientXRaysBefore as $beforeXRay)
                                                @php
                                                    $imagePath   = Storage::url($beforeXRay->image);
                                                    $imageExists = Storage::exists($beforeXRay->image);
                                                @endphp
                                                <img src="{{ Storage::url($beforeXRay->image) }}" alt="Image?" width="200" class="@if($imageExists) xray-image @endif mx-2" @if($imageExists) data-image="{{ Storage::url($beforeXRay->image) }}" @endif>
                                            @empty
                                                No X-rays (Before) yet.
                                            @endforelse
                                        </p>
                                    </div>
                                    <div class="tab-pane fade" id="in-between" role="tabpanel" aria-labelledby="in-between-tab">
                                        <p class="mb-0 m-t-20">
                                            @forelse($patientXRaysInBetween as $inBetweenXRay)
                                                @php
                                                    $imagePath   = Storage::url($inBetweenXRay->image);
                                                    $imageExists = Storage::exists($inBetweenXRay->image);
                                                @endphp
                                                <img src="{{ Storage::url($inBetweenXRay->image) }}" alt="Image?" width="200" class="@if($imageExists) xray-image @endif mx-2" @if($imageExists) data-image="{{ Storage::url($inBetweenXRay->image) }}" @endif>
                                            @empty
                                                No X-rays (In Between) yet.
                                            @endforelse
                                        </p>
                                    </div>
                                    <div class="tab-pane fade" id="after" role="tabpanel" aria-labelledby="after-tab">
                                        <p class="mb-0 m-t-20">
                                            @forelse($patientXRaysAfter as $afterXRay)
                                                @php
                                                    $imagePath   = Storage::url($afterXRay->image);
                                                    $imageExists = Storage::exists($afterXRay->image);
                                                @endphp
                                                <img src="{{ Storage::url($afterXRay->image) }}" alt="Image?" width="200" class="@if($imageExists) xray-image @endif mx-2" @if($imageExists) data-image="{{ Storage::url($afterXRay->image) }}" @endif>
                                            @empty
                                                No X-rays (After) yet.
                                            @endforelse
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End - Container-fluid --}}
              </div> <!-- /.col -->
            </div>
          </div>
        </div> <!-- / .card -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
@endsection

@push('styles')
<!-- CSS for Popup Modal -->
<style>
    .modal {
        background-color: rgba(14, 14, 14, 0.75);
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        height: auto;
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: rgb(255, 109, 109);
        text-decoration: none;
        cursor: pointer;
    }

    .xray-image {
        border: rgb(0, 67, 212) 3px solid;
    }

    .xray-image:hover {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<!-- JavaScript for Popup Modal -->
<script>
    // Get the modal
    var modal = document.getElementById("xrayModal");

    // Get the image and insert it inside the modal
    var imgs = document.getElementsByClassName("xray-image");
    var modalImg = document.getElementById("modalImage");
    for (var i = 0; i < imgs.length; i++) {
        imgs[i].onclick = function () {
            modal.style.display = "block";
            modalImg.src = this.dataset.image;
        }
    }

    // Get the close button
    var closeBtn = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endpush
