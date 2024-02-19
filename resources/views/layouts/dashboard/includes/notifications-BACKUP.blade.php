{{-- ***************************** Appointment Notification ***************************** --}}
@if(auth()->user()->user_type == "doctor" && !Route::is('appointments.index'))
    @php
        $newAppointments = \App\Models\Appointment::where('doctor_id', auth()->user()->id)
                            ->where('created_at', '>=', now()->subHours(24)) // Assuming "new" means created in the last 24 hours
                            ->exists();
    @endphp
    @if($newAppointments)
        <script>
            'use strict';
            var notify = $.notify('<i class="fa fa-bell-o text-danger"></i><strong>Loading</strong> page Do not close this page...', {
                type: 'theme',
                allow_dismiss: true,
                delay: 10000, // 10 seconds
                showProgressbar: true,
                timer: 50
            });

            setTimeout(function() {
                notify.update('message',
                    '<i class="fa fa-bell-o text-danger"></i>'+
                    // '<strong>Loading</strong>'+
                    '<a href="{{ route("appointments.index") }}" id="appointment-notification" class="appointment-notification text-decoration-underline">Check</a> the new appointments'+
                '');
            }, 1000);
        </script>
    @endif
@endif

{{-- @if(auth()->user()->user_type == "doctor")
@php
    $newAppointments = \App\Models\Appointment::where('doctor_id', auth()->user()->id)
        ->whereNull('diagnosis')
        ->where('created_at', '>=', now()->subHours(24)) // Assuming "new" means created in the last 24 hours
        ->get(); // Use get() to retrieve the actual appointment records

    // $latestAppointment = \App\Models\Appointment::sortByDesc('created_at')->first(); // The last added record
    // $latest = $latestAppointment && $latestAppointment->id === $appointment->id ? "" : "";
@endphp
@foreach($newAppointments as $appointment)
    @php
        $appointmentId = $appointment->id;
        $patientName   = $appointment->patient->first_name . ' ' . $appointment->patient->last_name;
    @endphp
    <script>
        'use strict';
        var appointmentId = {!! json_encode($appointmentId) !!}; // Encode the appointment id to prevent JavaScript errors
        var patientName   = {!! json_encode($patientName) !!}; // Encode the patient name to prevent JavaScript errors
        var notify = $.notify('<i class="fa fa-bell-o"></i> <a href="javascript:void(0)" class="appointment_{{ $appointmentId }} text-decoration-underline">Check</a> the new appointment (<span class="fw-bold">'+patientName+'</span>)', {
            type: 'theme',
            allow_dismiss: true,
            delay: 8000, // 8 seconds
            showProgressbar: true,
            timer: 300
        });

        // Add event listener to the anchor tag to redirect to the appointment show route
        $('.appointment_{{ $appointmentId }}').click(function(e) {
            e.preventDefault(); // Prevent default link behavior
            window.location.href = '{{ route("appointments.show", ["appointment" => ":appointmentId"]) }}'.replace(':appointmentId', {{ $appointmentId }});
        });

        // setTimeout(function() {
        //     notify.update('message',
        //         '<i class="fa fa-bell-o"></i>'+
        //         '<span class="text-danger fw-bold">[Latest]</span> <a href="javascript:void(0)" class="appointment_{{ $appointmentId }} text-decoration-underline">Check</a> the new appointment (<span class="fw-bold">'+patientName+'</span>)'+
        //     '');
        // }, 1000);
    </script>
@endforeach
@endif --}}

{{-- ***************************** Payment Notification ***************************** --}}
@if((auth()->user()->email === "doctor1@gmail.com" || auth()->user()->email === "doctor2@gmail.com" ||
auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" ||
auth()->user()->email === "stockcoders99@gmail.com") && !Route::is('payments.index'))
    @php
        $newPayments = \App\Models\Payment::where('created_at', '>=', now()->subHours(24)) // Assuming "new" means created in the last 24 hours
                        ->exists();
        // where('create_user_id', '!=', auth()->user()->id)
        //                 ->orWhere('update_user_id', '!=', auth()->user()->id)
                        // ->where('created_at', '>=', now()->subHours(24)) // Assuming "new" means created in the last 24 hours
                        // ->exists();
    @endphp
    @if($newPayments)
        <script>
            'use strict';
            var notify = $.notify('<i class="fa fa-money text-success"></i><strong>Loading</strong> page Do not close this page...', {
                type: 'theme',
                allow_dismiss: true,
                delay: 10000, // 10 seconds
                showProgressbar: true,
                timer: 50
            });

            setTimeout(function() {
                notify.update('message',
                    '<i class="fa fa-money text-success"></i>'+
                    // '<strong>Loading</strong>'+
                    '<a href="{{ route("payments.index") }}" id="payment-notification" class="payment-notification text-decoration-underline">Check</a> the new payments'+
                '');
            }, 1000);
        </script>
    @endif
@endif
