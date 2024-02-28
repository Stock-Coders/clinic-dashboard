@extends('layouts.dashboard.pdf-export-master')
@section('title') All {{ $patient->first_name .' '. $patient->last_name }}'s Receipts ({{ $patientPayments->count() }}) @endsection
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
                    <img src="{{ asset('assets/dashboard/images/custom-images/logos/black logo (transparent background).png') }}" alt="codex_software_services_logo" width="150">
                    <span class="fw-bold h4">Codex Software Services</span>
                </div> --}}
                {{-- <h3>اخصائي طب و جراحة الوجه و الفكين</h3> --}}
                {{-- <h2>All Receipts ({{ \App\Models\Receipt::count() }})</h2> --}}
            {{-- </div> --}}
          </div>
          <div class="card-body">
            {{-- @if($patientPayments->count() > 0) --}}
            <div class="print-btn-container">
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-secondary fw-bold" id="print-btn" onclick="printPageAndShowMessage();">طباعة</button>
                </div>
            </div>
            <div dir="rtl" class="mb-2">
                <span class="fw-bold text-decoration-underline">جميع إيصالات:</span>
                <span class="fw-bold text-primary">{{ $patient->first_name .' '. $patient->last_name }}</span>
            </div>
            {{-- @endif --}}
            <div class="table-responsive" dir="rtl">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>الإيصال (ID):</th>
                    <th>طريقة الدفع</th>
                    <th>التخفيض</th>
                    <th>السعر (ج.م)</th>
                    <th>التاريخ</th>
                    <th>الوقت</th>
                    <th>اّخر زيارة</th>
                    <th>أنشئت في</th>
                    <th>تم التحديث في</th>
                    <th>انشأ من قبل</th>
                    <th>تم التحديث بواسطة</th>
                    <th class="hidden-print-view text-center">اعرض للطباعة</th>
                    <th class="text-center hidden-print-view">إجراء</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($patientPayments as $payment)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $payment->id }}</td>
                    <td>
                        @if($payment->payment_method == 'vodafone_cash')
                            فودافون كاش
                        @elseif($payment->payment_method == 'credit_card')
                            بطاقة إئتمان
                        @else
                            كاش
                        @endif
                    </td>
                    <td>
                        <span class="text-center fw-bold text-dark fs-6">
                            @if($payment->discount == null || $payment->discount == 0)
                                0%
                            @elseif($payment->discount != null && $payment->discount >= 1)
                                {{ $payment->discount }}%
                            @endif
                        </span>
                    </td>
                    <td class="text-center">
                        @if($payment->discount != null && $payment->discount >= 1)
                        <del class="text-danger fw-bold">{{ $payment->amount_before_discount }}</del>
                        <br/>
                        <span class="badge bg-dark text-center text-light fs-6">{{ $payment->amount_after_discount }}</span>
                        @elseif($payment->discount == null || $payment->discount == 0)
                        <span class="badge bg-dark text-center text-light fs-6">{{ $payment->amount_after_discount }}</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $payment->payment_date)->format('d-M-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_time)->format('h:i A') }}</td>
                    <td>
                        @if ($payment->patient->lastVisits->isNotEmpty())
                            {{ \Carbon\Carbon::parse($payment->patient->lastVisits->last()->last_visit_date)->format('d M, Y') }}
                        @else
                            {{-- <span class="text-danger">No visits yet.</span> --}}
                            <span class="text-danger">لا توجد زيارات حتى الآن.</span>
                        @endif
                    </td>
                    <td>{{ optional($payment->created_at)->tz('Africa/Cairo')->format('d-M-Y') }}</td>
                    <td>{{ $payment->updated_at ? optional($payment->updated_at)->tz('Africa/Cairo')->format('d-M-Y, h:i A') : '—' }}</td>
                    <th>{{ $payment->create_user->username }}</th>
                    <th>{{ $payment->update_user->username ?? '—' }}</th>
                    <th class="text-center hidden-print-view">
                        <a class="btn btn-info btn-xs px-2" href="{{ route('receipts.show.pdf', [$payment->id]) }}">
                            <i class="icofont icofont-printer f-26"></i>
                        </a>
                    </th>
                    <th class="hidden-print-view">
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-warning text-dark btn-md m-1 px-3" href="{{ route('payments.show', [$payment->id, $patient->first_name]) }}"title="{{ $patient->first_name .' '. $patient->last_name }}">
                                <i class="icofont icofont-open-eye f-24"></i>
                            </a>
                            <a class="btn btn-primary btn-md m-1 px-3" href="{{ route('payments.edit', $payment->id) }}"title="Edit ({{ $patient->first_name .' '. $patient->last_name }})">
                                <i class="fa fa-edit f-18"></i>
                            </a>
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure that you want to delete ({{ $patient->first_name . ' '. $patient->last_name }})?');"title="{{"Delete ($patient->first_name $patient->last_name)"}}" class="btn btn-danger btn-md m-1 px-3"><i class="fa fa-trash-o f-18"></i></button>
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
        if({{ $patientPayments->count() }} > 0) {
            printPage();
        } else {
            // alert('No payments to print.');
            // alert('لا توجد عمليات دفع للطباعة.');
            const msg = '.لا توجد عمليات دفع للطباعة';
            Swal.fire({
                title: '!تحذير',
                text: msg,
                icon: 'info'
            });
        }
    }

    if({{ $patientPayments->count() }} < 1){
        document.addEventListener('keydown', function (event) {
            // Check if the key combination is Ctrl+P (keyCode 80)
            if (event.ctrlKey && (event.key === 'p' || event.key === 'P' || event.keyCode === 80)) {
                event.preventDefault();
                // alert('No payments to print.');
                // alert('لا توجد عمليات دفع للطباعة.');
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
