@php
    // Check if there are any new appointments or payments created in the last 24 hours
    $newAppointments = \App\Models\Appointment::where('created_at', '>=', now()->subHours(24))
                        ->where('doctor_id', auth()->user()->id) // Exclude appointments created by the current user
                        ->where('create_user_id', '!=', auth()->user()->id)
                        ->exists();

    $newPayments = \App\Models\Payment::where('created_at', '>=', now()->subHours(24))
                    ->where('create_user_id', '!=', auth()->user()->id) // Exclude payments created by the current user
                    ->exists();

    // Combine the notification message for both appointments and payments
    $notificationMessage = '';

    if ($newAppointments && !Route::is('appointments.index')) {
        $notificationMessage .= '<div class="notification-item"><i class="fa fa-bell-o text-danger"></i> <a href="http://localhost:8000/dashboard/appointments" id="appointment-notification" class="appointment-notification text-decoration-underline fw-bold">Check</a> the new appointments were created.</div>';
    }

    if ($newPayments && !Route::is('payments.index')) {
        $notificationMessage .= '<div class="notification-item"><i class="fa fa-money text-success"></i> <a href="http://localhost:8000/dashboard/payments" id="payment-notification" class="payment-notification text-decoration-underline fw-bold">Check</a> the new payments were received.</div>';
    }
@endphp

@if($newAppointments || $newPayments)
    <script>
        'use strict';
        var notify = $.notify('<div class="p-3"><strong>Loading...</strong></div>', {
            type: 'theme',
            allow_dismiss: true,
            delay: 10000, // 10 seconds
            showProgressbar: true,
            timer: 50
        });

        // Check if notification is already clicked
        // var notificationClicked = localStorage.getItem('notificationClicked');

        // if (!notificationClicked) {
            // var notify = $.notify('<div class="p-3"><strong>Loading...</strong></div>', {
            //     type: 'theme',
            //     allow_dismiss: true,
            //     delay: 10000, // 10 seconds
            //     showProgressbar: true,
            //     timer: 50
            // });
        // }

        setTimeout(function() {
            notify.update('message', '{!! $notificationMessage !!}' +
                // '<div class="notification-links">' +
                // 'Click <a href="{{ route("appointments.index") }}" class="text-decoration-underline">here</a> to view appointments.<br>' +
                // 'Click <a href="{{ route("payments.index") }}" class="text-decoration-underline">here</a> to view payments.' +
                // '</div>'
            '');
        }, 1000);

        // Handle click event on notification links
        // $('.appointment-notification, .payment-notification').click(function(e) {
        //     e.preventDefault();
        //     localStorage.setItem('notificationClicked', true); // Set flag in local storage
        //     window.location.href = $(this).attr('href');
        // });
    </script>
@endif
