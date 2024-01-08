@if(session()->has('successfullly'))
<div class="alert alert-success text-center">
    {{ session()->get('successfully') }}
</div>

@elseif(session()->has('failed'))
<div class="alert alert-danger text-center">
    {{ session()->get('failed') }}
</div>
@endif
