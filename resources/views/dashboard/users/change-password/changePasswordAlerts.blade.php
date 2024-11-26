@if(session()->has('fields_are_required'))
<div class="alert alert-danger text-center fw-bold text-light w-75 mx-auto" id="alert-danger-message">
    <p class="position-absolute top-0 end-0">
        <span class="close-btn f-30" onclick="dismissMessage('alert-danger-message');"><i class="icofont icofont-ui-close"></i></span>
    </p>
    {{ session()->get('fields_are_required') }}
</div>
@elseif(session()->has('old_pass_req_not_matching_db'))
<div class="alert alert-danger text-center fw-bold text-light w-75 mx-auto" id="alert-danger-message">
    <p class="position-absolute top-0 end-0">
        <span class="close-btn f-30" onclick="dismissMessage('alert-danger-message');"><i class="icofont icofont-ui-close"></i></span>
    </p>
    {{ session()->get('old_pass_req_not_matching_db') }}
</div>
@elseif(session()->has('confirm_not_matching_new'))
<div class="alert alert-danger text-center fw-bold text-light w-75 mx-auto" id="alert-danger-message">
    <p class="position-absolute top-0 end-0">
        <span class="close-btn f-30" onclick="dismissMessage('alert-danger-message');"><i class="icofont icofont-ui-close"></i></span>
    </p>
    {{ session()->get('confirm_not_matching_new') }}
</div>
@elseif(session()->has('new_pass_req_is_matching_old'))
<div class="alert alert-danger text-center fw-bold text-light w-75 mx-auto" id="alert-danger-message">
    <p class="position-absolute top-0 end-0">
        <span class="close-btn f-30" onclick="dismissMessage('alert-danger-message');"><i class="icofont icofont-ui-close"></i></span>
    </p>
    {{ session()->get('new_pass_req_is_matching_old') }}
</div>
@elseif(session()->has('new_pass_must_8_more_char'))
<div class="alert alert-danger text-center fw-bold text-light w-75 mx-auto" id="alert-danger-message">
    <p class="position-absolute top-0 end-0">
        <span class="close-btn f-30" onclick="dismissMessage('alert-danger-message');"><i class="icofont icofont-ui-close"></i></span>
    </p>
    {{ session()->get('new_pass_must_8_more_char') }}
</div>
@elseif(session()->has('error'))
<div class="alert alert-danger text-center fw-bold text-light w-75 mx-auto" id="alert-danger-message">
    <p class="position-absolute top-0 end-0">
        <span class="close-btn f-30" onclick="dismissMessage('alert-danger-message');"><i class="icofont icofont-ui-close"></i></span>
    </p>
    {{ session()->get('error') }}
</div>
@elseif(session()->has('password_changed_successfully'))
<div class="alert alert-success text-center fw-bold text-light w-75 mx-auto" id="alert-success-message">
    <p class="position-absolute top-0 end-0">
        <span class="close-btn f-30" onclick="dismissMessage('alert-success-message');"><i class="icofont icofont-ui-close"></i></span>
    </p>
    {{ session()->get('password_changed_successfully') }}
</div>
@endif
