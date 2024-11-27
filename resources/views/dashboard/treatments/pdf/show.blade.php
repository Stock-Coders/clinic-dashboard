@extends('layouts.dashboard.pdf-export-master')

@section('title')
@if($treatment->prescription_id != null && $treatment->appointment_id == null)
    {{ $treatment->prescription->appointment->patient->first_name .' '. $treatment->prescription->appointment->patient->last_name }}
@else($treatment->prescription_id == null && $treatment->appointment_id != null)
    {{ $treatment->appointment->patient->first_name .' '. $treatment->appointment->patient->last_name }}
@endif
's
treatment (ID: {{ $treatment->id }})
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="print-btn-container mt-3">
            <div class="d-flex justify-content-end">
                <button class="btn btn-secondary fw-bold mx-3" id="print-btn" onclick="printPage();">طباعة</button>
                <a href="{{ url()->previous() }}" class="btn btn-dark fw-bold" id="print-btn">ارجع للخلف <i class="icofont icofont-arrow-right"></i></a>
            </div>
        </div>
        <div class="card shadow mb-4 mt-3">
          <div class="card-body" dir="rtl">
            <div class="row">
              <div class="col-md-12">
                {{-- Start - Container-fluid --}}
                <div class="container-fluid">
                    <div class="row">
                      <div class="col-sm-12">
                        {{-- <p>
                            <a class="text-primary fw-bold text-decoration-underline" href="{{ route('treatmentsOfPatient.showIndex', $treatment->patient->id) }}">Click here</a> to see all the treatments of the current patient.
                        </p> --}}
                        <div class="card">
                            <div class="d-flex flex-row-reverse justify-content-between p-2" style="background-color: rgb(235, 241, 252);">
                                <div class="p-3">
                                    <img src="{{ asset('assets/dashboard/images/custom-images/logos/light_codex_logo.png') }}" alt="codex_logo" width="100">
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
                            <div class="card-header pb-0">
                                {{-- <div class="d-flex justify-content-center">
                                    @php $patientImage = $treatment->patient->image; @endphp
                                    <img src='{{ asset("/assets/dashboard/images/custom-images/patients/images/$patientImage") }}' alt="Patient Image?" width="200">
                                </div> --}}
                                {{-- <h1 class="text-center">الميعاد (treatment)</h1> --}}
                            </div>
                            <div class="card-body border border-2 border-dark">
                                <h1 class="text-center pb-4">جلسة العلاج (Treatment)</h1>
                                @if($treatment->prescription_id != null && $treatment->appointment_id == null)
                                <p><span class="fw-bold text-decoration-underline">المريض:</span> <span class="badge bg-success fs-5">{{ $treatment->prescription->appointment->patient->first_name .' '. $treatment->prescription->appointment->patient->last_name   }}</span></p>
                                <p><span class="text-primary fw-bold text-decoration-underline">الدكتور:</span> <span class="badge bg-info fs-5">{{ $treatment->prescription->appointment->doctor->profile->name ?? $treatment->prescription->appointment->doctor->username }}</span> </p>
                                @else($treatment->prescription_id == null && $treatment->appointment_id != null)
                                <p><span class="fw-bold text-decoration-underline">المريض:</span> <span class="badge bg-success fs-5">{{ $treatment->appointment->patient->first_name .' '. $treatment->appointment->patient->last_name   }}</span></p>
                                <p><span class="text-primary fw-bold text-decoration-underline">الدكتور:</span> <span class="badge bg-info fs-5">{{ $treatment->appointment->doctor->profile->name ?? $treatment->appointment->doctor->username }}</span> </p>
                                @endif
                                <h5><span class="text-decoration-underline">أسم الإجراء:</span>
                                    {{ $treatment->procedure_name }}
                                </h5>
                                <p>
                                    <span class="text-decoration-underline">نوع العلاج:</span> <span>{{ ucfirst($treatment->treatment_type) }}</span>
                                </p>
                                <p>
                                    <span class="text-decoration-underline">الحالة:</span>
                                    <span class="
                                    @if($treatment->status == "scheduled") badge bg-info text-dark
                                    @elseif($treatment->status == "completed") badge bg-success
                                    @else($treatment->status == "canceled") badge bg-danger
                                    @endif">
                                        @if($treatment->status == "scheduled")
                                        تم جدولته
                                        @elseif($treatment->status == "completed")
                                        منتهى
                                        @else($treatment->status == "canceled")
                                        ملغى
                                        @endif
                                    </span>
                                </p>
                                <p>
                                    <span class="text-decoration-underline">التاريخ:</span> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $treatment->treatment_date)->format('d-M-Y') }}
                                    <br/>
                                    <span class="text-decoration-underline">الوقت:</span> {{ \Carbon\Carbon::parse($treatment->treatment_time)->format('h:i A') }}
                                </p>
                                <p>
                                    <span class="bg-warning rounded-pill p-2 text-dark fw-bold h6">
                                        ملحوظات:
                                        <i class="icofont icofont-arrow-left f-18"></i>
                                    </span>
                                    @if($treatment->notes != null)
                                    <p>{{ $treatment->notes }}</p>
                                    @else
                                    <p class="text-danger">N/A</p>
                                    @endif
                                </p>
                                <hr/>
                                <p>
                                    <span class="text-decoration-underline">المبلغ (ج.م):</span> <span class="badge bg-dark text-light fs-6"> {{$treatment->cost }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <span class="h6">
                                دمياط - فارسكور - امتداد مركز الشرطة - خلف صيدليه الديب
                            </span>
                            <i class="icofont icofont-location-pin fs-5"></i>
                            <p class="mt-1">
                                <i class="icofont icofont-phone fs-5"></i>
                                +20 015 58 69 60 72
                            </p>
                        </div>
                        <div class="text-center">
                            @include('layouts.dashboard.includes.copy-right')
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
<style>
    @media print {
        .print-btn-container {
            display: none;
        }
    }

    #english-name {
        opacity: 50%;
    }
</style>
@endpush

@push('scripts')
<script>
    function printPage() {
        event.preventDefault();
        window.print();
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
