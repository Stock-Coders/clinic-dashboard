@extends('layouts.dashboard.pdf-export-master')
@section('title') All Prescriptions ({{ \App\Models\Prescription::count() }}) @endsection
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
            {{-- @if($prescriptions->count() > 0) --}}
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
                        <th>الروشتة</th>
                        <th>الحساسية</th>
                        <th>الميعاد (ID)</th>
                        <th>الزيارة القادمة</th>
                        <th>أنشئت في</th>
                        <th>تم التحديث في</th>
                        <th>انشأ من قبل</th>
                        {{-- <th>Updated by (Doctor)</th> --}}
                        <th class="hidden-print-view text-center">اعرض للطباعة</th>
                        <th class="hidden-print-view text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($prescriptions as $prescription)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        {{-- <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', [$prescription->appointment->patient_id, $prescription->appointment->patient->first_name]) }}"> --}}
                            {{ $prescription->appointment->patient->first_name .' '. $prescription->appointment->patient->last_name }}
                        {{-- </a> --}}
                    </td>
                    <td>{!! $prescription->prescription !!}</td>
                    <td>{{ $prescription->allergy ?? '—' }}</td>
                    <td class="text-center">{{ $prescription->appointment_id  }}</td>
                    <td>{{ $prescription->next_visit != null ? \Carbon\Carbon::parse($prescription->next_visit)->format('d-M-Y, h:i A') : '—' }}</td>
                    <td>{{ optional($prescription->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                    <td>{{ $prescription->updated_at ? optional($prescription->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $prescription->create_doctor->profile->name ?? $prescription->create_doctor->username }}</th>
                    {{-- <th>{{ $prescription->update_doctor->username ?? '—' }}</th> --}}
                    <th class="hidden-print-view text-center">
                        {{-- <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('patients.show', [$patient->id, $patient->first_name]) }}"title="{{ $patient->first_name .' '. $patient->last_name }}"> --}}
                            <i class="icofont icofont-open-eye f-24"></i>
                        {{-- </a> --}}
                    </th>
                    <th class="hidden-print-view text-center">
                        <a target="_blank" class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('prescriptions.show', $prescription->id) }}"title="{{ $prescription->appointment->patient->first_name }}'s appointment">
                            <i class="icofont icofont-open-eye f-24"></i>
                        </a>
                        <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('prescriptions.edit', $prescription->id) }}"title="Edit {{ $prescription->appointment->patient->first_name }}'s prescription">
                            <i class="fa fa-edit f-18"></i>
                        </a>
                        <form action="{{ route('prescriptions.destroy', $prescription->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $prescription->title }})?');"title="Delete {{ $prescription->appointment->patient->first_name }}'s prescription" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                        </form>
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
        if({{ $prescriptions->count() }} > 0) {
            printPage();
        } else {
            // alert('No prescriptions to print.');
            // alert('لا توجد رشتات للطباعة.');
            const msg = '.لا توجد رشتات للطباعة';
            Swal.fire({
                title: '!تحذير',
                text: msg,
                icon: 'info'
            });
        }
    }

    if({{ $prescriptions->count() }} < 1){
        document.addEventListener('keydown', function (event) {
            // Check if the key combination is Ctrl+P (keyCode 80)
            if (event.ctrlKey && (event.key === 'p' || event.key === 'P' || event.keyCode === 80)) {
                event.preventDefault();
                // alert('No prescriptions to print.');
                // alert('لا توجد رشتات للطباعة.');
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
