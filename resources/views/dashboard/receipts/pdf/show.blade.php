@extends('layouts.dashboard.pdf-export-master')
@section('title') {{ $payment->patient->first_name . ' ' . $payment->patient->last_name }}'s Receipt (ID: {{ $payment->id }}) @endsection
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
                            <a class="text-primary fw-bold text-decoration-underline" href="{{ route('appointmentsOfPatient.showIndex', $payment->patient->id) }}">Click here</a> to see all the appointments of the current patient.
                        </p> --}}
                        <div class="card">
                            <div class="d-flex flex-row-reverse justify-content-between p-2" style="background-color: rgb(235, 241, 252);">
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
                            <div class="card-header pb-0">
                            </div>
                            <div class="card-body border border-2 border-dark">
                                {{-- <h1 class="text-center pb-4">روشتة جلسة العلاج (Treatment's Prescription)</h1> --}}
                                <div class="d-flex justify-content-between">
                                    <div>
                                        {{-- <h5><span class="text-decoration-underline">الروشتة:</span>
                                            {{ $payment->treatment->prescription }}
                                        </h5> --}}
                                        <p><span class="fw-bold text-decoration-underline">اسم المريض:</span> <span class="badge bg-dark fs-5">{{ $payment->patient->first_name . ' ' . $payment->patient->last_name }}</span></p>
                                    </div>
                                    <div>
                                        <h6><span class="text-decoration-underline">التاريخ:</span>
                                            {{ optional($payment->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}
                                        </h6>
                                    </div>
                                </div>
                                <hr style="border:solid 3px rgb(145, 177, 236)"/>
                                <div class="d-flex justify-content-center">
                                    <span class="text-decoration-underline fw-bold h4">(ID) عملية الدفع:</span>&nbsp;
                                    <span class="fw-bold text-primary h4">{{ $payment->id }}</span>
                                </div>
                                <div class="d-flex justify-content-center px-4" dir="ltr">
                                    <div class="text-left mt-3">
                                        <p class="fs-5">
                                            <div dir="rtl">
                                                <table class="table table-bordered border-dark border border-2">
                                                    <thead>
                                                        <th class="bg-dark text-light border-secondary">التعريف</th>
                                                        <th class="bg-dark text-light border-secondary">المحتوي</th>
                                                        <th class="bg-dark text-light border-secondary">الكمية</th>
                                                        <th class="bg-dark text-light border-secondary">السعر (ج.م)</th>
                                                        <th class="bg-dark text-light border-secondary">الاجمالي (ج.م)</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-secondary text-light">طريقة الدفع:&nbsp;</th>
                                                            <td>
                                                                @if($payment->payment_method == 'vodafone_cash')
                                                                    فودافون كاش
                                                                    @elseif($payment->payment_method == 'credit_card')
                                                                    بطاقة إئتمان
                                                                    @else
                                                                    كاش
                                                                    @endif
                                                            </td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-secondary text-light">الموعد (ID):&nbsp;</th>
                                                            <td>
                                                                {{-- <a class="text-decoration-underline fw-bold" href="{{ route('appointments.show', $payment->appointment_id) }}"> --}}
                                                                    {{ $payment->appointment_id }}
                                                                    {{-- </a> --}}
                                                            </td>
                                                            <td>-</td>
                                                            <td>{{ $payment->appointment->cost }}</td>
                                                            <td class="fw-bold text-center" style="background-color: rgb(255, 250, 213);">{{ $payment->appointment->cost }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-secondary text-light">جلسة العلاج (ID):&nbsp;</th>
                                                            <td>
                                                                @if($payment->treatment_id)
                                                                {{-- <a class="text-decoration-underline fw-bold" href="{{ route('treatments.show', $payment->treatment_id) }}"> --}}
                                                                    {{ $payment->treatment_id }}
                                                                {{-- </a> --}}
                                                                @else
                                                                -
                                                                @endif
                                                            </td>
                                                            <td>-</td>
                                                            <td >{{ $payment->treatment->cost ?? '-' }}</td>
                                                            <td class="fw-bold text-center" style="background-color: rgb(255, 250, 213);">{{ $payment->treatment->cost ?? '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-secondary text-light"">المواد المستخدمة ({{ isset($payment->prescriptionTreatment->treatment->materials) ? $payment->prescriptionTreatment->treatment->materials->count() : 0 }}):&nbsp;</th>
                                                            <td>
                                                                <ul>
                                                                    @if(isset($payment->prescriptionTreatment->treatment->materials))
                                                                        @foreach ($payment->prescriptionTreatment->treatment->materials as $material)
                                                                            <li>{{ $material->title }}</li>
                                                                        @endforeach
                                                                    @else
                                                                    -
                                                                    @endif
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                @if($payment->prescription_treatment_id)
                                                                    <ul>
                                                                        @foreach ($payment->prescriptionTreatment->treatment->materials as $material)
                                                                            <li>{{ $material->pivot->material_quantity }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @else
                                                                -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($payment->prescription_treatment_id)
                                                                    <ul>
                                                                        @foreach ($payment->prescriptionTreatment->treatment->materials as $material)
                                                                            <li>{{ $material->cost }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @else
                                                                -
                                                                @endif
                                                            </td>
                                                            <td style="background-color: rgb(255, 250, 213);">
                                                                @if($payment->prescription_treatment_id)
                                                                    @php
                                                                        $totalCost  = 0;
                                                                    @endphp
                                                                    @foreach ($payment->prescriptionTreatment->treatment->materials as $material)
                                                                    @php
                                                                        $materialsTotalCost = $material->pivot->material_quantity * $material->cost;
                                                                        $totalCost += $materialsTotalCost;
                                                                    @endphp
                                                                    @endforeach
                                                                    <span style="height: 100px;" class="d-flex justify-content-center align-items-center fw-bold">
                                                                        {{ $totalCost }}
                                                                    </span>
                                                                @else
                                                                -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-secondary text-light">X-ray(s) (ID):&nbsp;</th>
                                                            <td>
                                                                @if($payment->xrays)
                                                                    @foreach($payment->xrays as $key => $xray)
                                                                        <span class="badge rounded-circle bg-primary"><span class="fw-bold">{{ $xray->id }}</span></span>
                                                                        <span class="text-danger fw-bold">{{ $key < $payment->xrays->count() - 1 ? '-' : '' }}</span>
                                                                    @endforeach
                                                                @else
                                                                -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($payment->xrays)
                                                                    {{ $payment->xrays->count() }}
                                                                @else
                                                                -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($payment->xrays)
                                                                    @php
                                                                        $totalXraysCost = 0;
                                                                    @endphp
                                                                    @foreach($payment->xrays as $xray)
                                                                        @php
                                                                            $totalXraysCost += $xray->cost;
                                                                        @endphp
                                                                    @endforeach
                                                                    {{ $totalXraysCost }}
                                                                @else
                                                                -
                                                                @endif
                                                            </td>
                                                            <td class="fw-bold text-center" style="background-color: rgb(255, 250, 213);">
                                                                {{ $totalXraysCost }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-secondary text-light">التخفيض:&nbsp;</th>
                                                            <td colspan="4" class="text-center fw-bold">
                                                                <span class="text-center text-dark fs-6">
                                                                    @if($payment->discount == null || $payment->discount == 0)
                                                                        0%
                                                                    @elseif($payment->discount != null && $payment->discount >= 1)
                                                                        {{ $payment->discount }}%
                                                                    @endif
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @if($payment->discount != null && $payment->discount >= 1)
                                                            <tr>
                                                                <th colspan="4" class="bg-secondary text-center text-light">السعر الاجمالي قبل التخفيض:&nbsp;</th>
                                                                <td style="background-color: rgb(253, 219, 219);" class="text-center text-dark fw-bold fs-6">
                                                                    <del class="text-danger">{{ $payment->amount_before_discount }}</del>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <th colspan="4" class="bg-secondary text-center text-light">السعر الاجمالي:&nbsp;</th>
                                                            <td style="background-color: rgb(255, 250, 213);" class="text-center bg-success text-light fw-bold fs-6">
                                                                {{ $payment->amount_after_discount }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </p>
                                    </div>
                                </div>
                                <hr class="w-75 mx-auto"/>
                                <div class="d-flex justify-content-evenly align-items-end align-content-end fs-5 mt-4">
                                    <p>
                                        <span class="text-muted fw-bold text-decoration-underline">اّخر:</span>
                                        .......
                                    </p>
                                    <p>
                                        <span class="text-dark fw-bold text-decoration-underline">الزيارة الماضية:</span>
                                        @if ($payment->patient->lastVisits->isNotEmpty())
                                            {{ \Carbon\Carbon::parse($payment->patient->lastVisits->last()->last_visit_date)->format('d M, Y') }}
                                        @else
                                            <span class="text-danger">لا توجد زيارات حتى الآن.</span>
                                        @endif
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
