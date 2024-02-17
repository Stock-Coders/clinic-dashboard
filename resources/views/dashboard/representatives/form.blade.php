<div class="form-group">
    <label for="name">Name <span class="text-danger">*</span></label>
    <input type="text" name="name" class="form-control border-1 border-dark mb-2 @error('name') is-invalid @enderror" id="name" placeholder="" value="{{old('name', $representative->name)}}">
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" class="form-control border-1 border-dark mb-2 @error('description') is-invalid @enderror" id="description" placeholder="" cols="30" rows="5">{{ old('description', $representative->description) }}</textarea>
    @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="address">Address</label>
    <input type="text" name="address" class="form-control border-1 border-dark mb-2 @error('address') is-invalid @enderror" id="address" placeholder="" value="{{old('address', $representative->address)}}">
    @error('address')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control border-1 border-dark mb-2 @error('email') is-invalid @enderror" id="email" placeholder="" value="{{old('email', $representative->email)}}">
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="website">Website / URL</label>
    <input type="url" name="website" class="form-control border-1 border-dark mb-2 @error('website') is-invalid @enderror" id="website" placeholder="" value="{{old('website', $representative->website)}}">
    @error('website')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="phone">Phone <span class="text-danger">*</span></label>
    <input type="text" name="phone" class="form-control border-1 border-dark mb-2 @error('phone') is-invalid @enderror" id="phone" placeholder="" value="{{old('phone', $representative->phone)}}">
    @error('phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="secondary_phone">Secondary Phone</label>
    <input type="text" name="secondary_phone" class="form-control border-1 border-dark mb-2 @error('secondary_phone') is-invalid @enderror" id="secondary_phone" placeholder="" value="{{old('secondary_phone', $representative->secondary_phone)}}">
    @error('secondary_phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
