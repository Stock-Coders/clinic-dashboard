@extends('layouts.dashboard.master')

@section('title')
All Treatments
@if(isset($materialsTreatments) && $materialsTreatments->isNotEmpty())
    ({{ \App\Models\Treatment::count() }})
@else
    (0)
@endif
&
Materials ({{ \App\Models\MaterialTreatment::count() }})
@endsection

@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
                @if(isset($materialsTreatments) && $materialsTreatments->isNotEmpty())
                    <h5>Treatments ({{ \App\Models\Treatment::count() }})</h5>
                @else
                    <h5>Treatments (0)</h5>
                @endif
                <h5>Treatment's Materials ({{ \App\Models\MaterialTreatment::count() }})</h5>
            </div>
            {{-- <h5>All Treatment's Materials ({{ \App\Models\MaterialTreatment::count() }})</h5> --}}
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / All Treatments & Materials
                </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Procedure Name (Treatment)</th>
                    <th>Treatment's Cost (EGP)</th>
                    <th>No. of Materials</th>
                    <th>Material(s)</th>
                    <th>Materials Quantity Used</th>
                    <th>Materials Cost/Unit (EGP)</th>
                    <th>Each Material Total Cost (EGP)</th>
                    <th>Total of Materials Quantities (EGP)</th>
                    <th>Total Cost [Treatment + Materials] (EGP)</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($materialsTreatments) && $materialsTreatments->isNotEmpty())
                    @foreach ($materialsTreatments as $materialTreatment)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>
                            @if($materialTreatment->prescription_id != null && $materialTreatment->appointment_id == null)
                            <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', $materialTreatment->prescription->appointment->patient_id) }}">
                                {{ $materialTreatment->prescription->appointment->patient->first_name .' '. $materialTreatment->prescription->appointment->patient->last_name }}
                            </a>
                            @else($materialTreatment->prescription_id == null && $materialTreatment->appointment_id != null)
                            <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', $materialTreatment->appointment->patient_id) }}">
                                {{ $materialTreatment->appointment->patient->first_name .' '. $materialTreatment->appointment->patient->last_name }}
                            </a>
                            @endif
                            {{-- ?? --}}
                        </td>
                        <td>{{ $materialTreatment->procedure_name }}</td>
                        <td>{{ $materialTreatment->cost }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill badge-info fs-6">
                                {{ $materialTreatment->materials->count() }}
                            </span>
                        </td>
                        <td>
                            <ul style="list-style-type: square;" class="px-2">
                                @foreach($materialTreatment->materials as $material)
                                    <li>{{ $material->title }}</li>
                                    {{-- @if($material->title)
                                        <li>&rightarrow; {{ $material->title }}</li>
                                    @endif --}}
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($materialTreatment->materials as $material)
                                    <li>&rightarrow; {{ $material->pivot->material_quantity }}</li>
                                    {{-- @if($material->pivot->material_quantity)
                                        <li>&rightarrow; {{ $material->pivot->material_quantity }}</li>
                                    @endif --}}
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($materialTreatment->materials as $material)
                                    <li>&rightarrow; {{ $material->cost }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($materialTreatment->materials as $material)
                                    <li class="text-success fw-bold">{{ $material->pivot->material_quantity * $material->cost }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-center">
                            <ul>
                                @php
                                    $materialsTotalCost = 0;
                                    foreach ($materialTreatment->materials as $material) {
                                        $materialsTotalCost += $material->pivot->material_quantity * $material->cost;
                                    }
                                @endphp
                                @foreach($materialTreatment->materials as $material)
                                    <li>
                                        <span class="badge badge-secondary f-14">
                                            {{ $materialsTotalCost }}
                                        </span>
                                    </li>
                                    @break
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-center">
                            <ul>
                                <li>
                                    <span class="badge badge-dark fs-6">
                                        {{ $materialsTotalCost + $materialTreatment->cost }}
                                    </span>
                                </li>
                            </ul>
                        </td>
                        {{-- <td>{{ $materialTreatment->doctor->profile->name ?? $materialTreatment->doctor->username }}</td> --}}
                        {{-- <td>{{ optional($materialTreatment->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                        <td>{{ $materialTreatment->updated_at ? optional($materialTreatment->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td> --}}
                        {{-- <th>{{ $materialTreatment->create_user->username }}</th>
                        <th>{{ $materialTreatment->update_user->username ?? '—' }}</th> --}}
                    </tr>
                    @endforeach
                @else
                    <p class="alert alert-danger text-center">There is no any association with the treatments and the materials found.</p>
                @endif
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

<script>
    $(document).ready(function() {
        // Initialize the totals variables
        var totalTreatmentCost = 0;
        var totalMaterialsQuantity = 0;
        var totalTreatmentAndMaterialCost = 0;
        // Initialize the total variable
        var totalFinalCost = 0;

        // Loop through each row in the table
        $('table tbody tr').each(function() {
            // Extract the values from the columns
            var treatmentCost = parseFloat($(this).find('td:eq(-8)').text().trim().replace(/[^\d.]/g, ''));
            var materialsTotalQuantity = parseFloat($(this).find('td:eq(8)').text().trim().replace(/[^\d.]/g, ''));
            // Extract the value from the final total cost column of each row
            var lastColumnValue = parseFloat($(this).find('td:last').text().trim().replace(/[^\d.]/g, ''));

            // Add the lastColumnValue to the total if it's a valid number
            if (!isNaN(lastColumnValue)) {
                totalFinalCost += lastColumnValue;
            }

            // Add the values to the totals
            totalTreatmentCost += isNaN(treatmentCost) ? 0 : treatmentCost;
            totalMaterialsQuantity += isNaN(materialsTotalQuantity) ? 0 : materialsTotalQuantity;
        });

        // Display the totals in the table footer
        $('table tbody').append(''+
        '<tr class="bordered">' +
            '<td class="text-center text-dark" colspan="1" style="background-color: rgb(168, 205, 250);"><span class="fw-bold">Totals</span></td>' +
            '<td colspan="1"></td>'+
            '<td colspan="1"></td>'+
            '<td class="text-center text-dark" colspan="1" style="background-color: rgb(255, 252, 193);"><span class="fw-bold">' + totalTreatmentCost.toFixed(2) + '</span></td>' +
            '<td colspan="1"></td>'+
            '<td colspan="1"></td>'+
            '<td colspan="1"></td>'+
            '<td colspan="1"></td>' +
            '<td colspan="1"></td>' +
            '<td class="text-center text-dark" colspan="1" style="background-color: rgb(255, 252, 193);"><span class="fw-bold">' + totalMaterialsQuantity.toFixed(2) + '</span></td>' +
            '<td class="text-center text-dark" colspan="1" style="background-color: rgb(0, 0, 0);">'+
                '<span class="badge badge-warning fs-6 fw-bold text-dark">' + totalFinalCost.toFixed(2) + '</span>'+
            '</td>' +
            // '<td class="text-center text-dark" colspan="1" style="background-color: rgb(0, 0, 0);">'+
            //     '<span class="badge badge-warning fs-6 fw-bold text-dark">'+
            //         '<input class="text-center" value="' + totalFinalCost.toFixed(2) + '"/>'+
            //         '<input value="Save!" class="btn btn-success btn-sm p-0 mx-2"/>'+
            //     '</span>'+
            // '</td>' +
        '</tr>');
    });
</script>
@endpush
