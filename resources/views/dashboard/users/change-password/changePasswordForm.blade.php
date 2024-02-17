<div class="form-group">
    <label>Old Password <span class="text-danger">*</span></label>
    <div class="input-group">
        <input type="password" name="old_password" id="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Enter your old password here..">
        <i onclick="show_hide_old_password();" id="dot-eye-icon-old-password" class="input-group-text fa fa-eye"></i>
    </div>
    @error('old_password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label>New Password <span class="text-danger">*</span></label>
    <div class="input-group">
        <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Enter your new password here..">
        <i onclick="show_hide_new_password();" id="dot-eye-icon-new-password" class="input-group-text fa fa-eye"></i>
    </div>
    @error('new_password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label>Confirm New Password <span class="text-danger">*</span></label>
    <div class="input-group">
        <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" placeholder="Confirm your new password here..">
        <i onclick="show_hide_confirm_new_password();" id="dot-eye-icon-confirm-new-password" class="input-group-text fa fa-eye"></i>
    </div>
</div>
