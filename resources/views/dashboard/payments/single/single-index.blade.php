@extends('layouts.dashboard.master')
@section('title') {{ $patient->first_name . ' ' . $patient->last_name }}'s Payments ({{ $patientPayments->count() }}) @endsection
@section('content')
<div class="container-fluid">
    <p>@include('layouts.dashboard.includes.alert')</p>
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5>
                <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', $patient->id) }}">{{ $patient->first_name . ' ' . $patient->last_name }}</a>'s Payments ({{ $patientPayments->count() }})
            </h5>
            <div class="row">
                <div class="col-md-9">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / {{ $patient->first_name . ' ' . $patient->last_name }}'s Payments
                </div>
                <div class="col-md-3">
                    <a href="{{ route('patient.payments.create', $patient->id) }}" class="btn btn-success-gradien">Create New Payment For {{ $patient->first_name }}</a>
                </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display" id="basic-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Payment ID</th>
                    <th>Payment Method</th>
                    <th>Amount (EGP)</th>
                    <th>Discount (%)</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Appointment (ID)</th>
                    <th>Treatment (ID)</th>
                    <th>Treatment's Prescription (ID)</th>
                    <th>X-ray(s) (ID)</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Created by</th>
                    <th>Updated by</th>
                    <th class="text-center">Print</th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th class="text-center">Action</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($patientPayments as $payment)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $payment->id }}</td>
                    <td>
                        @if($payment->payment_method == 'vodafone_cash')
                        Vodafone Cash
                        @elseif($payment->payment_method == 'credit_card')
                        Credit Card
                        @else
                        {{ ucfirst($payment->payment_method) }}
                        @endif
                    </td>
                    <td class="text-center">
                        @if($payment->discount != null && $payment->discount >= 1)
                        <del class="text-danger fw-bold">{{ $payment->amount_before_discount }}</del>
                        <span class="badge badge-dark text-center text-light fs-6">{{ $payment->amount_after_discount }}</span>
                        @elseif($payment->discount == null || $payment->discount == 0)
                        <span class="badge badge-dark text-center text-light fs-6">{{ $payment->amount_after_discount }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($payment->discount == null || $payment->discount == 0)
                        <span class="badge badge-info text-center f-14">0%</span>
                        @elseif($payment->discount != null && $payment->discount >= 1)
                        <span class="badge badge-warning text-center text-dark f-14">{{ $payment->discount }}%</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $payment->payment_date)->format('d-M-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_time)->format('h:i A') }}</td>
                    <td>
                        <a class="text-decoration-underline fw-bold" href="{{ route('appointments.show', $payment->appointment_id) }}">
                            {{ $payment->appointment_id }}{{ '- '.$payment->appointment->diagnosis }}
                        </a>
                    </td>
                    <td>
                        @if($payment->treatment_id)
                        <a class="text-decoration-underline fw-bold" href="{{ route('treatments.show', $payment->treatment_id) }}">
                            {{ $payment->treatment_id }}{{ '- '.$payment->treatment->procedure_name }}
                        </a>
                        @else
                        —
                        @endif
                    </td>
                    <td>
                        @if($payment->prescription_treatment_id)
                        <a class="text-decoration-underline fw-bold" href="{{ route('prescriptions-treatments.show', $payment->prescription_treatment_id) }}">
                            {{ $payment->prescription_treatment_id }}
                        </a>
                        @else
                        —
                        @endif
                    </td>
                    <td>
                        {{-- @if($payment->xrays)
                        <ul style="list-style-type: square;" class="px-2">
                            @foreach($payment->xrays as $xray)
                                <li>
                                    <a class="fw-bold" href="{{ route('x-rays.show', $xray->id) }}">
                                        {{ $xray->id.', ' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        @else
                        —
                        @endif --}}
                        @if($payment->xrays)
                            @foreach($payment->xrays as $key => $xray)
                                <a href="{{ route('x-rays.show', $xray->id) }}" class="text-decoration-none">
                                    <span class="badge rounded-circle badge-primary"><span class="fw-bold">{{ $xray->id }}</span></span>
                                </a>
                                <span class="text-danger fw-bold">{{ $key < $payment->xrays->count() - 1 ? '-' : '' }}</span>
                            @endforeach
                        @else
                        —
                        @endif
                    </td>
                    <td>{{ optional($payment->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                    <td>{{ $payment->updated_at ? optional($payment->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $payment->create_user->username }}</th>
                    <th>{{ $payment->update_user->username ?? '—' }}</th>
                    <th class="text-center">
                        <a class="btn btn-info btn-xs px-2" href="{{ route('receipts.show.pdf', [$payment->id]) }}">
                            <i class="icofont icofont-printer f-26"></i>
                        </a>
                    </th>
                    @if(in_array($authUserEmail, $allowedUsersEmails))
                    <th>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('payments.show', $payment->id) }}"title="{{ $payment->appointment->patient->first_name }} payment">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('patient.payments.edit', [$patient->id, $payment->id]) }}"title="Edit payment (ID: {{ $payment->id }})">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete (ID: {{ $payment->id }})\'s payment?');"title="Delete (ID: <?php echo $payment->id; ?>)" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                            </form>
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
