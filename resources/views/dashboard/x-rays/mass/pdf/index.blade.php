@extends('layouts.dashboard.pdf-export-master')
@section('title') Appointments ({{ \App\Models\Appointment::count() }}) @endsection
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
            {{-- @if($xrays->count() > 0) --}}
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
                    <th>الشكوى الرئيسية</th>
                    <th>العنوان</th>
                    <th>X-ray</th>
                    <th>التوقيت</th>
                    <th>التكلفة (ج.م)</th>
                    <th>ملحوظات</th>
                    <th>أنشئت في</th>
                    {{-- <th>تم التحديث في</th> --}}
                    {{-- <th>انشأ من قبل</th> --}}
                    {{-- <th>تم التحديث بواسطة</th> --}}
                    <th class="hidden-print-view text-center">اعرض للطباعة</th>
                    <th class="text-center hidden-print-view">إجراء</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($xrays as $xray)
                @php
                    $words = str_word_count($xray->notes, 2); // Get an associative array of words
                    $limitedWords = array_slice($words, 0, 4); // Limit to the first 4 words
                    $limitedNotes = implode(' ', $limitedWords) . (count($words) >= 4 ? '...' : ''); // Combine and add "..." if there are equal or more words
                @endphp
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        <a class="text-decoration-underline fw-bold" href="{{ route('patients.show', [$xray->patient_id, $xray->patient->first_name]) }}">
                            {{ $xray->patient->first_name .' '. $xray->patient->last_name }}
                        </a>
                    </td>
                    <td>
                        @if ($xray->patient->chief_complaint == "badly_aesthetic")
                            Badly Aesthetic
                        @elseif($xray->patient->chief_complaint == "severe_pain")
                            Severe Pain
                        @else
                            Mastication
                        @endif
                    </td>
                    <td>{{ $xray->title }}</td>
                    <td><img src="{{ Storage::url($xray->image) }}" alt="—" width="70"></td>
                    <td>{{ $xray->timing == "in_between" ? "In Between" : ucfirst($xray->timing) }}</td>
                    <td class="text-center">
                        <span class="badge rounded-pill badge-dark f-12">{{ $xray->cost }}</span>
                    </td>
                    <td>{{ $xray->notes !== null ? $limitedNotes : '—' }}</td>
                    <td>{{ optional($xray->created_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') }}</td>
                    <td>{{ $xray->updated_at ? optional($xray->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $xray->create_user->username }}</th>
                    <th>{{ $xray->update_user->username ?? '—' }}</th>
                    <th class="hidden-print-view text-center">
                        <a class="btn btn-info btn-xs px-2" href="{{ route('x-rays.show.pdf', [$xray->id]) }}">
                            <i class="icofont icofont-printer f-26"></i>
                        </a>
                    </th>
                    <th class="hidden-print-view">
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('x-rays.show', $xray->id) }}"title="Show {{ $xray->patient->first_name }}'s x-ray">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('x-rays.edit', $xray->id) }}"title="Edit {{ $xray->patient->first_name }}'s x-ray">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('x-rays.destroy', $xray->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete {{ $xray->patient->first_name . ' ' . $xray->patient->last_name }}\'s X-ray? with ID ({{ $xray->id }})');"title="Delete {{ $xray->patient->first_name }}'s x-ray?" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
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
        if({{ $xrays->count() }} > 0) {
            printPage();
        } else {
            // alert('No appointments to print.');
            // alert('لا توجد X-rays للطباعة.');
            const msg = '.لا توجد X-rays للطباعة';
            Swal.fire({
                title: '!تحذير',
                text: msg,
                icon: 'info'
            });
        }
    }

    if({{ $xrays->count() }} < 1){
        document.addEventListener('keydown', function (event) {
            // Check if the key combination is Ctrl+P (keyCode 80)
            if (event.ctrlKey && (event.key === 'p' || event.key === 'P' || event.keyCode === 80)) {
                event.preventDefault();
                // alert('No X-rays to print.');
                // alert('لا توجد X-rays للطباعة.');
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
