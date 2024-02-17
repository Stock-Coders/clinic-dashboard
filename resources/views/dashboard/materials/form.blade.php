<div class="form-group">
    <label for="title">Title <span class="text-danger">*</span></label>
    <input type="text" name="title" class="form-control border-1 border-dark mb-2 @error('title') is-invalid @enderror" id="title" placeholder="" value="{{old('title', $material->title)}}">
    @error('title')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" class="form-control border-1 border-dark mb-2 @error('description') is-invalid @enderror" id="description" placeholder="" cols="30" rows="5">{{ old('description', $material->description) }}</textarea>
    @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="quantity">Quantity</label>
    <input type="number" name="quantity" class="form-control border-1 border-dark mb-2 @error('quantity') is-invalid @enderror" id="quantity" value="{{old('quantity', $material->quantity)}}">
    @error('quantity')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="cost">Cost (EGP) <span class="text-danger">*</span></label>
    <input type="number" name="cost" class="form-control border-1 border-dark mb-2 @error('cost') is-invalid @enderror" id="cost" value="{{old('cost', $material->cost)}}">
    @error('cost')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="expiration_date">Expiration Date <span class="text-danger">*</span></label>
    <input type="date" name="expiration_date" class="form-control border-1 border-dark mb-2 @error('expiration_date') is-invalid @enderror" id="expiration_date" placeholder="" value="{{old('expiration_date', $material->expiration_date)}}">
    @error('expiration_date')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="representative_id">Representative <span class="text-danger">*</span></label>
    <select class="form-control border-1 border-dark @error('representative_id') is-invalid @enderror" name="representative_id" id="representative_id">
        <option selected>-------- Select a representative --------</option>
        {{-- @if($representatives->count() > 0)
        <option value="" selected>-------- Select a representative --------</option>
        @endif --}}
        @forelse($representatives as $representative)
        <option value="{{ $representative->id }}" {{ $representative->id == $material->representative_id ? 'selected' : '' }}>{{ $representative->name }}</option>
        @empty
        <option>No representatives.</option>
        @endforelse
    </select>
    @error('representative_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
