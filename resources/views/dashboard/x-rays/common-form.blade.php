<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control border-1 border-dark mb-2 @error('title') is-invalid @enderror" id="title" placeholder="" value="{{old('title', $xray->title)}}">
    @error('title')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="image">X-ray Image <span class="text-danger">*</span> @if(Route::is('x-rays.edit')) <span class="text-muted">(Already added an image! This field is optional to change.)</span> @endif</label>
    <input type="file" name="image" class="form-control border-1 border-dark mb-2 @error('image') is-invalid @enderror" id="image" value="{{old('image', $xray->image)}}" accept="image/*">
    @error('image')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label for="cost">Cost (EGP) <span class="text-danger">*</span></label>
            <input type="number" name="cost" class="form-control border-1 border-dark mb-2 @error('cost') is-invalid @enderror" id="cost" value="{{old('cost', $xray->cost)}}">
            @error('cost')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
            <label for="timing">Timing <span class="text-danger">*</span></label>
            <select class="form-control select border-1 border-dark mb-2 @error('timing') is-invalid @enderror" name="timing" id="timing">
                <option value="" selected>-------- Select a timing --------</option>
                <option value="before" {{$xray->timing == "before" ? 'selected' : ''}}>Before</option>
                <option value="in_between" {{$xray->timing == "in_between" ? 'selected' : ''}}>In Between</option>
                <option value="after" {{$xray->timing == "after" ? 'selected' : ''}}>After</option>
            </select>
            @error('timing')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="notes">Notes</label>
    <textarea name="notes" class="form-control border-1 border-dark mb-2 @error('notes') is-invalid @enderror" id="notes" placeholder="" cols="30" rows="5">{{ old('notes', $xray->notes) }}</textarea>
    @error('notes')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
