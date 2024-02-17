@extends('layouts.dashboard.pdf-export-master')
@section('title') All Patients ({{ \App\Models\Patient::count() }}) @endsection
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
            {{-- <div class="d-flex justify-content-start align-items-center"> --}}
                {{-- <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/dashboard/images/custom-images/logos/black logo (transparent background).png') }}" alt="stockcoders_logo" width="150">
                    <span class="fw-bold h4">StockCoders</span>
                </div> --}}
                {{-- <h3>اخصائي طب و جراحة الوجه و الفكين</h3> --}}
                {{-- <h2>All Patients ({{ \App\Models\Patient::count() }})</h2> --}}
            {{-- </div> --}}
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
                    {{-- <th>ID</th> --}}
                    <th>الأسم</th>
                    <th>اّخر زيارة</th>
                    <th>الشكوى الرئيسية</th>
                    <th>الأمراض المزمنة</th>
                    {{-- <th>Appointments</th> --}}
                    {{-- <th>X-rays</th> --}}
                    {{-- <th>Email</th> --}}
                    <th>الهاتف</th>
                    {{-- <th>Emergency Phone</th> --}}
                    {{-- <th>WhatsApp</th> --}}
                    {{-- <th>Date of Birth</th> --}}
                    <th>السن</th>
                    <th>الجنس</th>
                    <th>العنوان</th>
                    {{-- <th>أنشئت في</th> --}}
                    {{-- <th>Updated at</th> --}}
                    {{-- <th>انشأ من قبل</th> --}}
                    {{-- <th>Updated by</th> --}}
                    <th class="hidden-print-view text-center">اعرض للطباعة</th>
                    {{-- <th class="text-center">Action</th> --}}
                </tr>
                </thead>
                <tbody>
                @foreach ($patients as $patient)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    {{-- <td>{{ $patient->id }}</td> --}}
                    <td>{{ $patient->first_name .' '. $patient->last_name }} </td>
                    <td>
                        @if ($patient->lastVisits->isNotEmpty())
                            {{ \Carbon\Carbon::parse($patient->lastVisits->last()->last_visit_date)->format('d M, Y') }}
                        @else
                            {{-- <span class="text-danger">No visits yet.</span> --}}
                            <span class="text-danger">لا توجد زيارات حتى الآن.</span>
                        @endif
                    </td>
                    <td>
                        @if ($patient->chief_complaint == "badly_aesthetic")
                            Badly Aesthetic
                        @elseif($patient->chief_complaint == "severe_pain")
                            Severe Pain
                        @else
                            Mastication
                        @endif
                    </td>
                    <td>{{ $patient->chronic_disease ?? '—' }}</td>
                    {{-- <td>
                        <span class="fs-6">({{ $patient->appointment->count() }})</span>
                    </td> --}}
                    {{-- <td>
                        <span class="fs-6">({{ $patient->xray->count() }})</span>
                    </td> --}}
                    {{-- <td>{{ $patient->email ?? '—' }}</td> --}}
                    <td>{{ $patient->phone}}</td>
                    {{-- <td>{{ $patient->emergency_phone ?? '—' }}</td> --}}
                    {{-- <td>{{ $patient->whatsapp ?? '—' }}</td> --}}
                    {{-- <td>{{ \Carbon\Carbon::parse($patient->dob)->format('d-m-Y') }}</td> --}}
                    <td>{{ \Carbon\Carbon::parse($patient->dob)->diffInYears(\Carbon\Carbon::now()) }}</td>
                    <td>
                        {{-- {{ $patient->gender == 'male' ? 'M' : 'F' }} --}}
                        {{-- {{ $patient->gender == 'male' ? 'ذكر' : 'أنثى' }} --}}
                        @if($patient->gender == 'female')
                        <i class="fa fa-venus f-22" aria-hidden="true"></i>
                        @else
                        <i class="fa fa-mars f-22" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td>{{ $patient->address ?? '—' }}</td>
                    {{-- <td>{{ optional($patient->created_at)->tz('Africa/Cairo')->format('d-M-Y') }}</td> --}}
                    {{-- <td>{{ $patient->updated_at ? optional($patient->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td> --}}
                    {{-- <th>{{ $patient->create_user->username }}</th> --}}
                    {{-- <th>{{ $patient->update_user->username ?? '—' }}</th> --}}
                    <th class="hidden-print-view text-center">
                        {{-- <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('patients.show', [$patient->id, $patient->first_name]) }}"title="{{ $patient->first_name .' '. $patient->last_name }}"> --}}
                            <i class="icofont icofont-open-eye f-24"></i>
                        {{-- </a> --}}
                    </th>
                    {{-- <th>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('patients.show', [$patient->id, $patient->first_name]) }}"title="{{ $patient->first_name .' '. $patient->last_name }}">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('patients.edit', $patient->id) }}"title="Edit ({{ $patient->first_name .' '. $patient->last_name }})">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('patients.destroy', $patient->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $patient->first_name . ' '. $patient->last_name }})?');"title="{{"Delete ($patient->first_name $patient->last_name)"}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
                            </form>
                        </div>
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
        if({{ $patients->count() }} > 0) {
            printPage();
        } else {
            // alert('No patients to print.');
            // alert('لا يوجد مرضى للطباعة.');
            const msg = '.لا يوجد مرضي للطباعة';
            Swal.fire({
                title: '!تحذير',
                text: msg,
                icon: 'info'
            });
        }
    }

    if({{ $patients->count() }} < 1){
        document.addEventListener('keydown', function (event) {
            // Check if the key combination is Ctrl+P (keyCode 80)
            if (event.ctrlKey && (event.key === 'p' || event.key === 'P' || event.keyCode === 80)) {
                event.preventDefault();
                // alert('No patients to print.');
                // alert('لا يوجد مرضى للطباعة.');
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
