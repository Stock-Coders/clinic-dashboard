@if(session()->has('success'))
<div class="alert alert-success text-center w-75 mx-auto" id="alert-success-message">
    <p class="position-absolute top-0 end-0">
        <span class="close-btn f-30" onclick="dismissMessage('alert-success-message');"><i class="icofont icofont-ui-close"></i></span>
    </p>
    {{ session()->get('success') }}
</div>
@elseif(session()->has('warning'))
<div class="alert alert-warning text-center fw-bold text-dark w-75 mx-auto" id="alert-warning-message">
    <p class="position-absolute top-0 end-0">
        <span class="close-btn f-30" onclick="dismissMessage('alert-warning-message');"><i class="icofont icofont-ui-close"></i></span>
    </p>
    {{ session()->get('warning') }}
</div>
@elseif(session()->has('error'))
<div class="alert alert-danger text-center w-75 mx-auto" id="alert-danger-message">
    <p class="position-absolute top-0 end-0">
        <span class="close-btn f-30" onclick="dismissMessage('alert-danger-message');"><i class="icofont icofont-ui-close"></i></span>
    </p>
    {{ session()->get('error') }}
</div>
@endif
