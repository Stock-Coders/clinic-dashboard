<div class="form-group">
    <label for="username">Username <span class="text-danger">*</span></label>
    <input type="text" name="username" class="form-control border-1 border-dark mb-2 @error('username') is-invalid @enderror" id="username" placeholder="" value="{{old('username', $user->username)}}">
    @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="email">Email Address <span class="text-danger">*</span></label>
    <input type="email" name="email" class="form-control border-1 border-dark @error('email') is-invalid @enderror" id="email" placeholder="" value="{{old('email', $user->email)}}">
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


@if(Route::is('users.create'))
<div class="form-group">
    <label for="password">Password <span class="text-danger">*</span></label>
    <input type="password" name="password" class="form-control border-1 border-dark @error('password') is-invalid @enderror" id="password" placeholder="">
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="password-confirm">Confirm Password <span class="text-danger">*</span></label>
    <input type="password" name="password_confirmation" class="form-control border-1 border-dark" id="password-confirm" placeholder="">
</div>
@endif

<div class="form-group">
    <label for="phone">Phone <span class="text-danger">*</span></label>
    <input type="text" name="phone" class="form-control border-1 border-dark @error('phone') is-invalid @enderror" id="phone" placeholder="" value="{{old('phone', $user->phone)}}">
    @error('phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

@if($user->id !== auth()->user()->id && (auth()->user()->email === "doctor1@gmail.com" ||
auth()->user()->email === "doctor2@gmail.com" || auth()->user()->email === "kareemtarekpk@gmail.com" ||
auth()->user()->email === "mr.hatab055@gmail.com" || auth()->user()->email === "stockcoders99@gmail.com"))
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="account_status">Account Status <span class="text-danger">*</span></label>
                <select class="form-control border-1 border-dark @error('account_status') is-invalid @enderror" name="account_status" id="account_status">
                    <option value="" selected>-------- Select an account status --------</option>
                    <option value="active" {{ $user->account_status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ $user->account_status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    <option value="deactivated" {{ $user->account_status === 'deactivated' ? 'selected' : '' }}>Deactivated</option>
                </select>
                @error('account_status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="user_type">User Type <span class="text-danger">*</span></label>
                <select class="form-control border-1 border-dark @error('user_type') is-invalid @enderror" name="user_type" id="user_type">
                    <option value="" selected>-------- Select a user type --------</option>
                    <option value="doctor" {{ $user->user_type === 'doctor' ? 'selected' : '' }}>Doctor</option>
                    <option value="employee" {{ $user->user_type === 'employee' ? 'selected' : '' }}>Employee</option>
                    @if(auth()->user()->email === "kareemtarekpk@gmail.com" || auth()->user()->email === "mr.hatab055@gmail.com" || auth()->user()->email === "stockcoders99@gmail.com")
                    <option value="developer" {{ $user->user_type === 'developer' ? 'selected' : '' }}>Developer</option>
                    @endif
                </select>
                @error('user_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="user_role">User Role</label>
                <input type="text" name="user_role" class="form-control border-1 border-dark mb-2 @error('user_role') is-invalid @enderror" id="user_role" placeholder="" value="{{old('user_role', $user->user_role)}}">
                @error('user_role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
@else
    {{-- Start hidden inputs => they are presented with their old values because they are required but they are hidden. --}}
    <input name="account_status" hidden value="{{old('account_status', $user->account_status)}}">
    <input name="user_type" hidden value="{{old('user_type', $user->user_type)}}">
    {{-- End hidden inputs --}}
    <div class="form-group">
        <label for="user_role">User Role</label>
        <input type="text" name="user_role" class="form-control border-1 border-dark mb-2 @error('user_role') is-invalid @enderror" id="user_role" placeholder="" value="{{old('user_role', $user->user_role)}}">
        @error('user_role')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@endif
