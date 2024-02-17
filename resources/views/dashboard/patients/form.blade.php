<div class="form-group">
    <label for="first_name">Frist Name <span class="text-danger">*</span></label>
    <input type="text" name="first_name" class="form-control border-1 border-dark mb-2 @error('first_name') is-invalid @enderror" id="first_name" placeholder="" value="{{$patient->first_name ?? ''}}">
    @error('first_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="last_name">Last Name <span class="text-danger">*</span></label>
    <input type="text"name="last_name" class="form-control border-1 border-dark mb-2 @error('last_name') is-invalid @enderror" id="last_name" placeholder="" value="{{old('last_name', $patient->last_name)}}">
    @error('last_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="chief_complaint">Chief Complaint <span class="text-danger">*</span></label>
    <select class="form-control select border-1 border-dark mb-2 @error('chief_complaint') is-invalid @enderror" name="chief_complaint" id="chief_complaint">
        <option value="" selected>-------- Select a chief complaint --------</option>
        <option value="badly_aesthetic" {{$patient->chief_complaint == "badly_aesthetic" ? 'selected' : ''}}>Badly Aesthetic</option>
        <option value="severe_pain" {{$patient->chief_complaint == "severe_pain" ? 'selected' : ''}}>Severe Pain</option>
        <option value="mastication" {{$patient->chief_complaint == "mastication" ? 'selected' : ''}}>Mastication</option>
    </select>
    @error('chief_complaint')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="chronic_disease">Chronic Disease</label>
    <input type="text" name="chronic_disease" class="form-control border-1 border-dark mb-2 @error('chronic_disease') is-invalid @enderror" id="chronic_disease" placeholder="" value="{{$patient->chronic_disease ?? ''}}">
    @error('chronic_disease')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control border-1 border-dark mb-2 @error('iamge') is-invalid @enderror" id="image" value="{{ old('image', $patient->image) }}">
            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control border-1 border-dark mb-2 @error('email') is-invalid @enderror" id="email" placeholder="" value="{{old('email', $patient->email)}}">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="phone">Phone <span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control border-1 border-dark mb-2 @error('phone') is-invalid @enderror" id="phone" placeholder="" value="{{old('phone', $patient->phone)}}">
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="emergency_phone">Emergency Phone</label>
            <input type="text" name="emergency_phone" class="form-control border-1 border-dark mb-2 @error('emergency_phone') is-invalid @enderror" id="emergency_phone" placeholder="" value="{{old('emergency_phone', $patient->emergency_phone)}}">
            @error('emergency_phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="whatsapp">WhatsApp</label>
            <input type="text" name="whatsapp" class="form-control border-1 border-dark mb-2 @error('whatsapp') is-invalid @enderror" id="whatsapp" placeholder="" value="{{old('phone', $patient->phone)}}">
            @error('whatsapp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="dob">Date of Birth <span class="text-danger">*</span></label>
            <input type="date" name="dob" class="form-control border-1 border-dark mb-2 @error('dob') is-invalid @enderror" id="dob" placeholder="" value="{{old('dob', $patient->dob)}}">
            @error('dob')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label class="col-sm-4 ">Gender <span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <div class="d-flex col-md-12 justify-content-evenly p-2 rounded">
                    <div>
                        <input type="radio" class="@error('gender') is-invalid @enderror" name="gender" value="male" {{ $patient->gender == "male" ? 'checked' : '' }}>
                        <label class="mb-0">Male</label>
                    </div>
                    <div>
                        <input type="radio" class="@error('gender') is-invalid @enderror" name="gender" value="female" {{$patient->gender == "female" ? 'checked' : '' }}>
                        <label class="mb-0">Female</label>
                    </div>
                </div>
                @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
</div>

{{--  Address --}}
<div class="form-group">
    <label for="address">Address <span class="text-danger">*</span></label>
    <input type="text" name="address" class="form-control border-1 border-dark mb-2 @error('address') is-invalid @enderror" id="address" placeholder="" value="{{old('phone', $patient->phone)}}">
    @error('address')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

{{-- insurance_info --}}


