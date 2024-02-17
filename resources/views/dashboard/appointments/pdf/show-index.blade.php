@extends('layouts.dashboard.pdf-export-master')
@section('title') {{ $patient->first_name }}'s Appointments ({{ $patient->appointment()->count() }}) @endsection
@section('content')
<div class="container-fluid">
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
                <div class="p-3">
                    <img src="{{ asset('assets/dashboard/images/custom-images/logos/light_codex_full_logo.png') }}" alt="codex_logo" width="200">
                </div>
                <div id="clinic-logo">
                    <img src="{{ asset('assets/dashboard/images/custom-images/logos/teeth-logo.png') }}" alt="clinic_logo" width="200">
                </div>
                <div class="text-center">
                    <span class="h5">دكتور</span>
                    <p><h1>محمد قدري فايد</h1></p>
                    <p id="english-name" class="h5">Dr. Mohamed Qadri Fayed</p>
                    <h5>اخصائي طب و جراحة الفم و الأسنان</h5>
                </div>
            </div>
          </div>
          <div class="card-body">
            {{-- @if($appointmentsOfPatient->count() > 0) --}}
            <div class="print-btn-container">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-secondary fw-bold" id="print-btn" onclick="printPageAndShowMessage();">طباعة</button>
                </div>
            </div>
            {{-- @endif --}}
            <p dir="rtl">
                {{-- <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', [$patient->id, $patient->first_name]) }}"> --}}
                {{-- All <span class="text-primary">{{ $patient->first_name .' '. $patient->last_name }}</span>'s Appointments --}}
                {{-- </a> --}}
                جميع مواعيد
                &leftarrow;
                <span class="text-primary fw-bold">{{ $patient->first_name .' '. $patient->last_name }}</span>
            </p>
            <div class="table-responsive" dir="rtl">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>زيارة</th>
                    <th>التشخيص</th>
                    <th>الحالة</th>
                    <th>الدكتور</th>
                    <th>التكلفة (ج.م)</th>
                    <th>التاريخ</th>
                    <th>الوقت</th>
                    <th>أنشئت في</th>
                    <th class="hidden-print-view text-center">اعرض للطباعة</th>
                    {{-- <th>تم التحديث في</th> --}}
                    {{-- <th>انشأ من قبل</th> --}}
                    {{-- <th>تم التحديث بواسطة</th> --}}
                    <th class="text-center hidden-print-view">إجراء</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($appointmentsOfPatient as $patientAppointment)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td class="text-center">
                            @if($patientAppointment->appointment_reason == 'examination')
                            <span class="badge bg-secondary fw-bolder fs-6">فحص/كشف</span>
                            @else
                            <span class="badge bg-warning text-dark fw-bolder fs-6">اعادة</span>
                            @endif
                        </td>
                        <td class="@if($patientAppointment->diagnosis == null) text-center @endif">
                            @if($patientAppointment->diagnosis != null)
                                <span>{{ $patientAppointment->diagnosis }}</span>
                            @else
                                <span class="text-danger">غير موقعة</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="fs-6
                            @if($patientAppointment->status == "scheduled") badge bg-info text-dark
                            @elseif($patientAppointment->status == "completed") badge bg-success
                            @else($patientAppointment->status == "canceled") badge bg-danger
                            @endif">
                                @if($patientAppointment->status == "scheduled")
                                تم جدولته
                                @elseif($patientAppointment->status == "completed")
                                منتهى
                                @else($patientAppointment->status == "canceled")
                                ملغى
                                @endif
                            </span>
                        </td>
                        <th>{{ $patientAppointment->doctor->profile->name ?? $patientAppointment->doctor->username }}</th>
                        <td class="text-center">
                            <span class="badge rounded-pill badge-dark f-12">{{ $patientAppointment->cost }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $patientAppointment->appointment_date)->format('d-M-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($patientAppointment->appointment_time)->format('h:i A') }}</td>
                        <td>{{ optional($patientAppointment->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                        <th class="hidden-print-view text-center">
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('appointments.show.pdf', [$patientAppointment->patient->id]) }}"title="{{ $patientAppointment->patient->first_name .' '. $patientAppointment->patient->last_name }}">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                        </th>
                        {{-- <td>{{ $patientAppointment->updated_at ? optional($patientAppointment->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td> --}}
                        {{-- <th>{{ $patientAppointment->create_user->username }}</th> --}}
                        {{-- <th>{{ $patientAppointment->update_user->username ?? '—' }}</th> --}}
                        <th class="text-center hidden-print-view">
                            <div class="d-flex justify-content-between">
                                <a target="_blank" class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('appointments.show', $patientAppointment->id) }}"title="{{ $patientAppointment->patient->first_name }} appointment">
                                    <i class="icofont icofont-open-eye f-24"></i>
                                </a>
                                <a target="_blank" class="btn btn-primary btn-md m-1 px-3" href="{{ route('appointments.edit', $patientAppointment->id) }}"title="Edit ({{ $patientAppointment->patient->first_name }}) appointment">
                                    <i class="fa fa-edit f-18"></i>
                                </a>
                                <form action="{{ route('appointments.destroy', $patientAppointment->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $patientAppointment->patient->first_name . ' '. $patientAppointment->patient->last_name }})\'s appointment?');"title="Delete (<?php echo $patientAppointment->patient->first_name . '\'s appointment'; ?>)" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                                </form>
                            </div>
                        </th>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            {{-- <div class="print-btn-container text-center mt-3">
                <button class="btn btn-info" id="print-btn" onclick="event.preventDefault(); printPage();">Print</button>
            </div> --}}
          </div>
            <div class="text-center">
                <span class="h6">
                    دمياط - فارسكور - امتداد مركز الشرطة - خلف صيدليه الديب
                </span>
                <i class="icofont icofont-location-pin fs-5"></i>
                <p class="mt-1">
                    <i class="icofont icofont-phone fs-5"></i>
                    +20 015 58 69 60 72
                </p>
            </div>
            <div class="text-center mb-1">
                @include('layouts.dashboard.includes.copy-right')
            </div>
        </div>
      </div>
      <!-- Zero Configuration  Ends-->
    </div>
  </div>
@endsection

@push('styles')
<style>
    @media print {
        .print-btn-container,
        .hidden-print-view {
            display: none;
        }
    }

    #english-name {
        opacity: 50%;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endpush

@push('scripts')
<script>
    function printPage() {
        window.print();
    }

    function printPageAndShowMessage() {
        event.preventDefault();
        if({{ $appointmentsOfPatient->count() }} > 0) {
            printPage();
        } else {
            // alert('No appointments to print.');
            // alert('لا توجد مواعيد للطباعة.');
            const msg = '.لا توجد مواعيد للطباعة';
            Swal.fire({
                title: '!تحذير',
                text: msg,
                icon: 'info'
            });
        }
    }

    if({{ $appointmentsOfPatient->count() }} < 1){
        document.addEventListener('keydown', function (event) {
            // Check if the key combination is Ctrl+P (keyCode 80)
            if (event.ctrlKey && (event.key === 'p' || event.key === 'P' || event.keyCode === 80)) {
                event.preventDefault();
                // alert('No appointments to print.');
                // alert('لا توجد مواعيد للطباعة.');
                return false;
            }
        });
    }

    document.oncontextmenu = () => { //"Right Click" -> of mouse
        // alert("Sorry! This action isn't allowed.");
        return false;
    }

    document.onkeydown = (e) => {
        if(e.ctrlKey && e.key == 'u' || e.ctrlKey && e.key == 'U'){   //"ctrl + u" OR "ctrl + U" -> for viewing page source
            // alert("Sorry! You can't view the page source.");
            return false;
        }
        if(e.key == 'F12'){   //"F12" -> for page's inspect element
            // alert("Sorry! You can't inspect element for this page.");
            return false;
        }
        if(e.ctrlKey && e.shiftKey && e.key == 'c' || e.ctrlKey && e.shiftKey && e.key == 'C'){   //"ctrl + shift + c" OR "ctrl + shift + C" -> for page's inspect element
            // alert("Sorry! You can't inspect element for this page.");
            return false;
        }
        // if(e.ctrlKey && e.key == 'c' || e.ctrlKey && e.key == 'C'){   //"ctrl + c" OR "ctrl + C" -> for copying
        //     // alert("Sorry! You can't view the page source.");
        //     return false;
        // }
        if(e.ctrlKey && e.key == 'v' || e.ctrlKey && e.key == 'V'){   //"ctrl + v" OR "ctrl + V" -> for pasting
            // alert("Sorry! You can't view the page source.");
            return false;
        }
        // if(e.ctrlKey && e.key == 'p' || e.ctrlKey && e.key == 'P'){   //"ctrl + v" OR "ctrl + V" -> for printing
        //     // alert("Sorry! You can't open the print page.");
        //     return false;
        // }
    }
</script>
@endpush
