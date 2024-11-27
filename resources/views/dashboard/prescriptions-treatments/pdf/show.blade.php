@extends('layouts.dashboard.pdf-export-master')
@section('title') {{ $prescriptionTreatment->treatment->appointment->patient->first_name . ' ' . $prescriptionTreatment->treatment->appointment->patient->last_name }}'s Prescrition (ID: {{ $prescriptionTreatment->treatment->id }}) @endsection
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
                            <a class="text-primary fw-bold text-decoration-underline" href="{{ route('appointmentsOfPatient.showIndex', $prescriptionTreatment->treatment->appointment->patient->id) }}">Click here</a> to see all the appointments of the current patient.
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
                                {{-- <h1 class="text-center pb-4">روشتة جلسة العلاج (Treatment's Prescription)</h1> --}}
                                <div class="d-flex justify-content-between">
                                    <div>
                                        {{-- <h5><span class="text-decoration-underline">الروشتة:</span>
                                            {{ $prescriptionTreatment->treatment->prescription }}
                                        </h5> --}}
                                        <p><span class="fw-bold text-decoration-underline">اسم المريض:</span> <span class="badge bg-dark fs-5">{{ $prescriptionTreatment->treatment->appointment->patient->first_name . ' ' . $prescriptionTreatment->treatment->appointment->patient->last_name }}</span></p>
                                    </div>
                                    <div>
                                        <h6><span class="text-decoration-underline">التاريخ:</span>
                                            {{ optional($prescriptionTreatment->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}
                                        </h6>
                                    </div>
                                </div>
                                <hr style="border:solid 3px rgb(145, 177, 236)"/>
                                <div class="d-flex justify-content-center">
                                    <span class="text-decoration-underline h4">جلسة علاج:</span>&nbsp;
                                    <span class="fw-bold h4">{{ $prescriptionTreatment->treatment->procedure_name }}</span>
                                </div>
                                <div>
                                    <span><span class="text-decoration-underline h5"># المواد:</span> <span class="badge rounded-pill bg-secondary fs-6">{{ $prescriptionTreatment->treatment->materials->count() }}</span></span>
                                </div>
                                <div class="d-flex justify-content-center px-4" dir="ltr">
                                    <div class="text-left mt-3">
                                        <p class="fs-5">
                                            {{-- <ul>
                                                <div class="row">
                                                    @foreach($prescriptionTreatment->treatment->materials->chunk(1) as $chunk)
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            @foreach($chunk as $material)
                                                                <li>
                                                                    {{ $material->title }}
                                                                    ({{ $material->pivot->material_quantity }})
                                                                </li>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </ul> --}}

                                            {{-- <ul>
                                                @foreach($prescriptionTreatment->treatment->materials as $material)
                                                    <li>
                                                        {{ $material->title }}
                                                        [{{ $material->pivot->material_quantity }}]
                                                    </li>
                                                @endforeach
                                            </ul> --}}

                                            <div dir="rtl">
                                                <table class="table table-bordered border-dark border border-2">
                                                    <thead class="print-view text-light" style="background-color: rgb(116, 116, 116);">
                                                      <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">اسم المادة</th>
                                                        <th scope="col">الكمية</th>
                                                        <th scope="col">السعر/الوحدة</th>
                                                        <th scope="col">السعر الكلي</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($prescriptionTreatment->treatment->materials as $material)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td scope="row">{{ $material->title }}</td>
                                                            <td>{{ $material->pivot->material_quantity }}</td>
                                                            <td>{{ $material->cost }}</td>
                                                            <td>{{ $material->pivot->material_quantity * $material->cost }}</td>
                                                        </tr>
                                                        @endforeach
                                                        <tr class="bg-dark">
                                                            <th class="bg-success text-center text-light fw-bold" colspan="4">الاجمالي</th>
                                                            <td style="background-color: rgb(255, 250, 213);" class="text-center text-dark fw-bold">
                                                                @php
                                                                    $totalCost  = 0;
                                                                @endphp
                                                                @foreach ($prescriptionTreatment->treatment->materials as $material)
                                                                @php
                                                                    $materialsTotalCost = $material->pivot->material_quantity * $material->cost;
                                                                    $totalCost += $materialsTotalCost;
                                                                @endphp
                                                                @endforeach
                                                                {{ $totalCost }}
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
                                    {{-- <p>
                                        <span class="text-decoration-underline">الزيارة:</span> <span class="text-muted">
                                            @if($prescriptionTreatment->treatment->appointment->appointment_cause == 'examination')
                                            <span class="badge bg-secondary fw-bolder fs-6">فحص/كشف</span>
                                            @else
                                            <span class="badge bg-warning text-dark fw-bolder fs-6">اعادة</span>
                                            @endif
                                        </span>
                                    </p> --}}
                                    <p><span class="text-muted fw-bold text-decoration-underline">جلسة العلاج (ID):</span> {{ $prescriptionTreatment->treatment_id }}</p>
                                    <p><span class="text-primary fw-bold text-decoration-underline">الدكتور:</span> {{ $prescriptionTreatment->treatment->appointment->doctor->profile->name ?? $prescriptionTreatment->treatment->appointment->doctor->username }}</p>
                                    <p class="fs-6"><span class="fw-bold text-decoration-underline">الزيارة القادمة:</span>
                                        {{ $prescriptionTreatment->next_visit != null ? \Carbon\Carbon::parse($prescriptionTreatment->next_visit)->format('d-M-Y, h:i A') : '—' }}
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
