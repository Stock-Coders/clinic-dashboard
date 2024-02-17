@if(session()->has('fields_are_required'))
<div class="alert alert-danger text-center w-75 mx-auto">
    {{ session()->get('fields_are_required') }}
</div>
@elseif(session()->has('old_pass_req_not_matching_db'))
<div class="alert alert-danger text-center w-75 mx-auto">
    {{ session()->get('old_pass_req_not_matching_db') }}
</div>
@elseif(session()->has('confirm_not_matching_new'))
<div class="alert alert-danger text-center w-75 mx-auto">
    {{ session()->get('confirm_not_matching_new') }}
</div>
@elseif(session()->has('new_pass_req_is_matching_old'))
<div class="alert alert-danger text-center w-75 mx-auto">
    {{ session()->get('new_pass_req_is_matching_old') }}
</div>
@elseif(session()->has('new_pass_must_8_more_char'))
<div class="alert alert-danger text-center w-75 mx-auto">
    {{ session()->get('new_pass_must_8_more_char') }}
</div>
@elseif(session()->has('password_changed_successfully'))
<div class="alert alert-success text-center w-75 mx-auto">
    {{ session()->get('password_changed_successfully') }}
</div>
@endif
