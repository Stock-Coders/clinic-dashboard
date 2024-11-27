@extends('layouts.dashboard.pdf-export-master')
@section('title') All Treatments' Prescriptions ({{ \App\Models\PrescriptionTreatment::count() }}) @endsection
@section('content')
<div class="container-fluid">
    <div class="row">
      <!-- Zero Configuration  Starts-->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
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
          </div>
          <div class="card-body">
            {{-- @if($prescriptionsTreatments->count() > 0) --}}
            <div class="print-btn-container">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-secondary fw-bold" id="print-btn" onclick="printPageAndShowMessage();">طباعة</button>
                </div>
            </div>
            {{-- @endif --}}
            <div class="table-responsive" dir="rtl">
              <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المريض</th>
                        {{-- <th>الروشتة</th> --}}
                        <th>الحساسية</th>
                        <th>جلسة العلاج</th>
                        <th>الزيارة القادمة</th>
                        <th>أنشئت في</th>
                        <th>تم التحديث في</th>
                        <th>انشأ من قبل</th>
                        {{-- <th>Updated by (Doctor)</th> --}}
                        <th class="hidden-print-view text-center">اعرض للطباعة</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                @foreach ($prescriptionsTreatments as $p_t_)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        @if($p_t_->treatment->prescription_id == null)
                        {{-- <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', [$p_t_->treatment->appointment->patient_id, $p_t_->treatment->appointment->patient->first_name]) }}"> --}}
                            {{ $p_t_->treatment->appointment->patient->first_name .' '. $p_t_->treatment->appointment->patient->last_name }}
                        {{-- </a> --}}
                        @else
                        {{-- <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', [$p_t_->treatment->prescription->appointment->patient_id, $p_t_->treatment->prescription->appointment->patient->first_name]) }}"> --}}
                            {{ $p_t_->treatment->prescription->appointment->patient->first_name .' '. $p_t_->treatment->prescription->appointment->patient->last_name }}
                        {{-- </a> --}}
                        @endif
                    </td>
                    {{-- <td>{{ $p_t_->prescription }}</td> --}}
                    <td>{{ $p_t_->allergy ?? '—' }}</td>
                    <td class="text-center">({{ $p_t_->treatment->id }}) - {{$p_t_->treatment->procedure_name  }}</td>
                    <td>{{ $p_t_->next_visit != null ? \Carbon\Carbon::parse($p_t_->next_visit)->format('d-M-Y, h:i A') : '—' }}</td>
                    <td>{{ optional($p_t_->created_at)->format('d-M-Y, h:i A') }}</td>
                    <td>{{ $p_t_->updated_at ? optional($p_t_->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $p_t_->create_doctor->username }}</th>
                    {{-- <th>{{ $p_t_->update_doctor->username ?? '—' }}</th> --}}
                    <th class="hidden-print-view text-center">
                            <i class="icofont icofont-open-eye f-24"></i>
                    </th>
                    {{-- <th>
                        @if($p_t_->treatment->prescription_id == null && $p_t_->treatment->appointment_id != null)
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('prescriptions-treatments.edit', $p_t_->id) }}"title="Edit {{ $p_t_->treatment->appointment->patient->first_name }}'s prescription">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('prescriptions-treatments.destroy', $p_t_->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $p_t_->treatment->appointment->patient->first_name . ' ' . $p_t_->treatment->appointment->patient->last_name }})?');"title="Delete {{ $p_t_->treatment->appointment->patient->first_name }}'s prescription" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                            </form>
                        @else
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('prescriptions-treatments.edit', $p_t_->id) }}"title="Edit {{ $p_t_->treatment->prescription->appointment->patient->first_name }}'s prescription">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('prescriptions-treatments.destroy', $p_t_->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $p_t_->treatment->prescription->appointment->patient->first_name . ' ' . $p_t_->treatment->prescription->appointment->patient->last_name }})?');"title="Delete {{ $p_t_->treatment->prescription->appointment->patient->first_name }}'s prescription" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                            </form>
                        @endif
                    </th> --}}
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
        if({{ $prescriptionsTreatments->count() }} > 0) {
            printPage();
        } else {
            // alert('No treatments\' prescriptions to print.');
            // alert('لا توجد رشتات جلسات العلاج للطباعة.');
            const msg = '.لا توجد رشتات جلسات العلاج للطباعة';
            Swal.fire({
                title: '!تحذير',
                text: msg,
                icon: 'info'
            });
        }
    }

    if({{ $prescriptionsTreatments->count() }} < 1){
        document.addEventListener('keydown', function (event) {
            // Check if the key combination is Ctrl+P (keyCode 80)
            if (event.ctrlKey && (event.key === 'p' || event.key === 'P' || event.keyCode === 80)) {
                event.preventDefault();
                // alert('No treatments\' prescriptions to print.');
                // alert('لا توجد رشتات جلسات العلاج للطباعة.');
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
