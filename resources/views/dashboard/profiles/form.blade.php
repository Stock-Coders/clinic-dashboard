{{-- @if($user->profile->avatar !== null)
<div class="form-group">
    <img src="{{ $user->profile->avatar }}">
</div>
@endif --}}

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control border-1 border-dark mb-2 @error('name') is-invalid @enderror" id="name" placeholder="" value="{{ $user->profile->name ?? '' }}">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="avatar">Avatar</label>
            <input type="file" name="avatar" class="form-control border-1 border-dark mb-2 @error('avatar') is-invalid @enderror" id="avatar" value="{{ $user->profile->avatar ?? '' }}">
            @error('avatar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="bio">Bio</label>
    <textarea name="bio" class="form-control border-1 border-dark mb-2 @error('bio') is-invalid @enderror" id="bio" placeholder="" cols="30" rows="5">{{ old('bio', $user->profile->bio) }}</textarea>
    @error('bio')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="dob">Date of Birth</label>
    <input type="date" name="dob" class="form-control border-1 border-dark mb-2 @error('dob') is-invalid @enderror" id="dob" placeholder="" value="{{ $user->profile->dob ?? '' }}">
    @error('dob')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="row">
    @if($user->email !== "codexsoftwareservices01@gmail.com")
    <div class="col-md-4">
        <div class="form-group row">
            <label class="col-sm-4">Gender <span class="text-danger">*</span></label>
            <div class="col-sm-9">
                <div class="d-flex col-md-12 justify-content-between p-2 rounded">
                    <div>
                        <input type="radio" class="@error('gender') is-invalid @enderror" name="gender" value="male" {{ optional($user->profile)->gender == "male" ? 'checked' : '' }}>
                        <label class="mb-0">Male</label>
                    </div>
                    <div>
                        <input type="radio" class="@error('gender') is-invalid @enderror" name="gender" value="female" {{ optional($user->profile)->gender == "female" ? 'checked' : '' }}>
                        <label class="mb-0">Female</label>
                    </div>
                </div>
                {{-- @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror --}}
            </div>
        </div>
    </div>
    @endif
    <div class="col-md-4 @if($user->email === "codexsoftwareservices01@gmail.com") col-md-6 @endif">
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control border-1 border-dark mb-2 @error('address') is-invalid @enderror" id="address" placeholder="" value="{{ $user->profile->address ?? '' }}">
            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 @if($user->email === "codexsoftwareservices01@gmail.com") col-md-6 @endif">
        <div class="form-group">
            <label for="secondary_phone">Secondary Phone</label>
            <input type="text" name="secondary_phone" class="form-control border-1 border-dark @error('secondary_phone') is-invalid @enderror" id="secondary_phone" placeholder="" value="{{ $user->profile->secondary_phone ?? '' }}">
            @error('secondary_phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="whatsapp">WhatsApp</label>
            <input type="text" name="whatsapp" class="form-control border-1 border-dark mb-2 @error('whatsapp') is-invalid @enderror" id="whatsapp" placeholder="" value="{{ $user->profile->whatsapp ?? '' }}">
            @error('whatsapp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="facebook">Facebook</label>
            <input type="text" name="facebook" class="form-control border-1 border-dark @error('facebook') is-invalid @enderror" id="facebook" placeholder="" value="{{ $user->profile->facebook ?? '' }}">
            @error('facebook')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group d-none">
    <label for="user_id">User <span class="text-danger">*</span></label>
    <input name="user_id" class="form-control border-1 border-dark mb-2 @error('user_id') is-invalid @enderror" id="user_id" placeholder="" value="{{ $user->id ?? '' }}">
    @error('user_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

