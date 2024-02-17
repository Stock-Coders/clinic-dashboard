{{-- undo action - when "softDeleted" show the (restore) functionality --}}
@if(session()->has('medicalHistoryDestroyMsg'))
    @php
        $softDeleteInfo = session()->get('medicalHistoryDestroyMsg');
    @endphp
    <div class="alert alert-success text-center w-75 mx-auto" id="undoAction-container">
        <p class="position-absolute top-0 end-0">
            <span class="close-btn f-30" onclick="dismissMessage('undoAction-container');"><i class="icofont icofont-ui-close"></i></span>
        </p>
        {{ $softDeleteInfo['medical_history_soft_delete'] }} <a href="{{ route('medical-histories.trash') }}" id="medical-histories-trash" class="text-decoration-underline fw-bold">Check the trash <i class="fa fa-trash-o"></i></a>
        <div id="undoAction">
            {{-- Want to undo? --}}
            <a href="{{ route('medical-histories.restore', $softDeleteInfo['medical_history_id']) }}" class="text-decoration-underline text-light fw-bold">
                Click here to undo <i class="fa fa-spin fa-refresh"></i>
            </a>
            <p>You have <span id="countdown">15</span> seconds to undo.</p>
        </div>
    </div>

{{-- redo action - when "restored" show the (destroy) functionality --}}
@elseif(session()->has('medicalHistoryRestoreMsg'))
    @php
        $restoreInfo = session()->get('medicalHistoryRestoreMsg');
    @endphp
    <div class="alert alert-success text-center w-75 mx-auto" id="redoAction-container">
        <p class="position-absolute top-0 end-0">
            <span class="close-btn f-30" onclick="dismissMessage('redoAction-container');"><i class="icofont icofont-ui-close"></i></span>
        </p>
        {{ $restoreInfo['medical_history_restore'] }}
        <div id="redoAction">
            {{-- Want to redo? --}}
            <form action="{{ route('medical-histories.destroy', $restoreInfo['medical_history_id']) }}" method="post" id="medical_histories_destroy">
                @csrf
                @method('DELETE')
                <a class="text-decoration-underline text-light fw-bold" style="cursor: pointer;" onclick="document.querySelector('#medical_histories_destroy').submit(); return false;">
                    Click here to redo <i class="fa fa-trash-o"></i>
                </a>
                <p>You have <span id="countdown">15</span> seconds to redo.</p>
            </form>
        </div>
    </div>
@endif

<style>
#medical-histories-trash {
    color: rgb(177, 231, 0);
}

.close-btn {
    cursor: pointer;
    color: snow;
    transition: 0.3s ease-in-out;
    margin-right: 10px;
}

.close-btn:hover {
    color: rgb(255, 109, 109);
    transition: 0.3s ease-in-out;
}
</style>

<script>
// Closing the containers by clickig on the close button
function dismissMessage(containerId) {
    let container = document.getElementById(containerId);
    if (container) {
        container.style.display = 'none';
    }
}

// Define the initial countdown time in seconds
var countDownTime = 15; // seconds

// Update the counter every second
var counterInterval = setInterval(function() {
    countDownTime--;

    // Update the counter text
    document.querySelector('#countdown').innerText = countDownTime;

    // If the countdown reaches 0, clear the interval and perform the action
    if (countDownTime <= 0) {
        clearInterval(counterInterval);
        // Hide the undoAction or redoAction div based on which one is present
        const undoAction = document.querySelector('#undoAction');
        const redoAction = document.querySelector('#redoAction');
        if (undoAction) {
            document.querySelector('#undoAction').style.display = 'none';
        } else if (redoAction) {
            document.querySelector('#redoAction').style.display = 'none';
        }
    }
}, 1000);
</script>
