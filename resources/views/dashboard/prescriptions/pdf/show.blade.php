@extends('layouts.dashboard.pdf-export-master')
@section('title') {{ $prescription->appointment->patient->first_name . ' ' . $prescription->appointment->patient->last_name }}'s Prescrition (ID: {{ $prescription->id }}) @endsection
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
                            <a class="text-primary fw-bold text-decoration-underline" href="{{ route('appointmentsOfPatient.showIndex', $prescription->appointment->patient->id) }}">Click here</a> to see all the appointments of the current patient.
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
                            </div>
                            <div class="card-body border border-2 border-dark">
                                {{-- <h1 class="text-center pb-4">الروشتة (Prescription)</h1> --}}
                                <div class="d-flex justify-content-between">
                                    <div>
                                        {{-- <h5><span class="text-decoration-underline">الروشتة:</span>
                                            {{ $prescription->prescription }}
                                        </h5> --}}
                                        <p><span class="fw-bold text-decoration-underline">اسم المريض:</span> <span class="badge bg-dark fs-5">{{ $prescription->appointment->patient->first_name . ' ' . $prescription->appointment->patient->last_name }}</span></p>
                                    </div>
                                    <div>
                                        <h6><span class="text-decoration-underline">التاريخ:</span>
                                            {{ optional($prescription->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}
                                        </h6>
                                    </div>
                                </div>
                                <hr style="border:solid 3px rgb(145, 177, 236)"/>
                                <div class="d-flex justify-content-start px-4" dir="ltr">
                                    <div class="text-left mt-3">
                                        <p class="fs-5">
                                            {!! $prescription->prescription !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-evenly align-items-end align-content-end fs-5 mt-4">
                                    <p>
                                        <span class="text-decoration-underline">الزيارة:</span> <span class="text-muted">
                                            @if($prescription->appointment->appointment_cause == 'examination')
                                            <span class="badge bg-secondary fw-bolder fs-6">فحص/كشف</span>
                                            @else
                                            <span class="badge bg-warning text-dark fw-bolder fs-6">اعادة</span>
                                            @endif
                                        </span>
                                    </p>
                                    <p><span class="text-muted fw-bold text-decoration-underline">الميعاد (ID):</span> {{ $prescription->appointment_id }}</p>
                                    <p><span class="text-primary fw-bold text-decoration-underline">الدكتور:</span> {{ $prescription->appointment->doctor->profile->name ?? $prescription->appointment->doctor->username }}</p>
                                    <p class="fs-6"><span class="fw-bold text-decoration-underline">الزيارة القادمة:</span>
                                        {{ $prescription->next_visit != null ? \Carbon\Carbon::parse($prescription->next_visit)->format('d-M-Y, h:i A') : '—' }}
                                    </p>
                                </div>
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
        return true;
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
