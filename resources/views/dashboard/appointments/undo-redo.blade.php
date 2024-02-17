{{-- undo action - when "softDeleted" show the (restore) functionality --}}
@if(session()->has('AppointmentDestroyMsg'))
    @php
        $softDeleteInfo = session()->get('AppointmentDestroyMsg');
    @endphp
    <div class="alert alert-success text-center w-75 mx-auto" id="undoAction-container">
        <p class="position-absolute top-0 end-0">
            <span class="close-btn f-30" onclick="dismissMessage('undoAction-container');"><i class="icofont icofont-ui-close"></i></span>
        </p>
        {{ $softDeleteInfo['appointment_soft_delete'] }} <a href="{{ route('appointments.trash') }}" style="color: rgb(177, 231, 0);" class="text-decoration-underline fw-bold">Check the trash <i class="fa fa-trash-o"></i></a>
        <div id="undoAction">
            {{-- Want to undo? --}}
            <a href="{{ route('appointments.restore', $softDeleteInfo['appointment_id']) }}" class="text-decoration-underline text-light fw-bold">
                Click here to undo <i class="fa fa-spin fa-refresh"></i>
            </a>
            <p>You have <span id="countdown">15</span> seconds to undo.</p>
        </div>
    </div>

{{-- redo action - when "restored" show the (destroy) functionality --}}
@elseif(session()->has('AppointmentRestoreMsg'))
    @php
        $restoreInfo = session()->get('AppointmentRestoreMsg');
    @endphp
    <div class="alert alert-success text-center w-75 mx-auto" id="redoAction-container">
        <p class="position-absolute top-0 end-0">
            <span class="close-btn f-30" onclick="dismissMessage('redoAction-container');"><i class="icofont icofont-ui-close"></i></span>
        </p>
        {{ $restoreInfo['appointment_restore'] }}
        <div id="redoAction">
            {{-- Want to redo? --}}
            <form action="{{ route('appointments.destroy', $restoreInfo['appointment_id']) }}" method="post" id="appointments_destroy">
                @csrf
                @method('DELETE')
                <a class="text-decoration-underline text-light fw-bold" style="cursor: pointer;" onclick="document.querySelector('#appointments_destroy').submit(); return false;">
                    Click here to redo <i class="fa fa-trash-o"></i>
                </a>
                <p>You have <span id="countdown">15</span> seconds to redo.</p>
            </form>
        </div>
    </div>
@endif
