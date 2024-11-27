@extends('layouts.dashboard.pdf-export-master')
@section('title') Treatments ({{ \App\Models\Treatment::count() }}) @endsection
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
            {{-- @if($treatments->count() > 0) --}}
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
                    <th>اسم العلاج</th>
                    <th>نوع العلاج</th>
                    <th>الدكتور</th>
                    <th>الحالة</th>
                    <th>التكلفة (ج.م)</th>
                    <th>التاريخ</th>
                    <th>الوقت</th>
                    <th>ملحوظات</th>
                    {{-- <th>(ID) الروشتة</th> --}}
                    <th>(ID) الموعد</th>
                    <th>أنشئت في</th>
                    {{-- <th>تم التحديث في</th> --}}
                    <th class="hidden-print-view text-center">اعرض للطباعة</th>
                    <th class="text-center hidden-print-view">إجراء</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($treatments as $treatment)
                    @php
                        $words = str_word_count($treatment->notes, 2); // Get an associative array of words
                        $limitedWords = array_slice($words, 0, 4); // Limit to the first 4 words
                        $limitedNotes = implode(' ', $limitedWords) . (count($words) >= 4 ? '...' : ''); // Combine and add "..." if there are equal or more words
                    @endphp
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>
                            @if($treatment->prescription_id != null && $treatment->appointment_id == null)
                            {{-- <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', $treatment->prescription->appointment->patient_id) }}"> --}}
                                {{ $treatment->prescription->appointment->patient->first_name .' '. $treatment->prescription->appointment->patient->last_name }}
                            {{-- </a> --}}
                            @else($treatment->prescription_id == null && $treatment->appointment_id != null)
                            {{-- <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', $treatment->appointment->patient_id) }}"> --}}
                                {{ $treatment->appointment->patient->first_name .' '. $treatment->appointment->patient->last_name }}
                            {{-- </a> --}}
                            @endif
                        </td>
                        <td>{{ $treatment->procedure_name }}</td>
                        <td>{{ ucfirst($treatment->treatment_type) }}</td>
                        <th>
                            @if($treatment->prescription_id != null && $treatment->appointment_id == null)
                            {{-- <a class="text-decoration-underline fw-bold" href="{{ route('users.show', $treatment->prescription->appointment->doctor_id) }}"> --}}
                                {{ $treatment->prescription->appointment->doctor->profile->name ?? $treatment->prescription->appointment->doctor->username }}
                            {{-- </a> --}}
                            @else($treatment->prescription_id == null && $treatment->appointment_id != null)
                            {{-- <a class="text-decoration-underline fw-bold" href="{{ route('users.show', $treatment->appointment->doctor_id) }}"> --}}
                                {{ $treatment->appointment->doctor->profile->name ?? $treatment->appointment->doctor->username }}
                            {{-- </a> --}}
                            @endif
                        </th>
                        <td class="text-center">
                            <span class="fs-6
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
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-dark">{{ $treatment->cost }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $treatment->treatment_date)->format('d-M-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($treatment->treatment_time)->format('h:i A') }}</td>
                        <td>{{ $treatment->notes !== null ? $limitedNotes : '—' }}</td>
                        {{-- <td>
                            @if($treatment->prescription_id != null && $treatment->appointment_id == null)
                                {{ '('.$treatment->prescription_id.')' }}
                            @endif
                        </td> --}}
                        <td>
                            @if($treatment->prescription_id == null && $treatment->appointment_id != null) {{-- for the appointment (directly) --}}
                            {{ '('.$treatment->appointment_id.')' }}
                            @else {{-- for the appointment that came from the prescription (indirectly) --}}
                            {{ '('.$treatment->prescription->appointment_id.')' }}
                            @endif
                        </td>
                        <td>{{ optional($treatment->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                        {{-- <td>{{ $treatment->updated_at ? optional($treatment->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td> --}}
                        <th class="hidden-print-view text-center">
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('treatments.show.pdf', [$treatment->id]) }}">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                        </th>
                        <th class="text-center hidden-print-view">
                            <div class="d-flex justify-content-between">
                                <a target="_blank" class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('treatments.show', $treatment->id) }}">
                                    <i class="icofont icofont-open-eye f-24"></i>
                                </a>
                                <a target="_blank" class="btn btn-primary btn-md m-1 px-3" href="{{ route('treatments.edit', $treatment->id) }}">
                                    <i class="fa fa-edit f-18"></i>
                                </a>
                                <form action="{{ route('treatments.destroy', $treatment->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure that you want to delete ()\'s appointment?');"title="Delete ()" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
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
        if({{ $treatments->count() }} > 0) {
            printPage();
        } else {
            // alert('No treatments to print.');
            // alert('لا توجد جلسات علاج للطباعة.');
            const msg = '.لا توجد جلسات علاج للطباعة';
            Swal.fire({
                title: '!تحذير',
                text: msg,
                icon: 'info'
            });
        }
    }

    if({{ $treatments->count() }} < 1){
        document.addEventListener('keydown', function (event) {
            // Check if the key combination is Ctrl+P (keyCode 80)
            if (event.ctrlKey && (event.key === 'p' || event.key === 'P' || event.keyCode === 80)) {
                event.preventDefault();
                // alert('No treatments to print.');
                // alert('لا توجد جلسات علاج للطباعة.');
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
