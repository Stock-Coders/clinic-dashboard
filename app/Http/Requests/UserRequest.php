<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    protected function onCreate() : array
    {
    return [
            'username'            => 'required|string|max:255|unique:users,username',
            'email'               => 'required|email|max:255|unique:users,email',
            'password'            => 'required|string|min:8|confirmed',
            'phone'               => 'required|digits:11|numeric|unique:users,phone',
            'account_status'      => 'required|in:active,suspended,deactivated',
            'user_type'           => 'required|in:doctor,employee,developer',
            'user_role'           => 'nullable|string|max:255',
            // 'last_login_datetime' => 'nullable',
            // 'last_login_ip'       => 'nullable',
        ];
}

   /**
    * @return array
    */

    protected function onUpdate() : array
    {
        $id = $this->route('user'); // Assuming your route parameter is named 'user'

        return [
            'username'       => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($id)],
            'email'          => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id)],
            'phone'          => ['required', 'numeric', 'digits:11', Rule::unique('users', 'phone')->ignore($id)],
            'account_status' => ['required', Rule::in(['active', 'suspended', 'deactivated'])],
            'user_type'      => ['required', Rule::in(['doctor', 'employee', 'developer'])],
            'user_role'      => 'nullable|string|max:255',
            // 'last_login_datetime' => 'nullable',
            // 'last_login_ip'       => 'nullable',
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ?
            $this->onUpdate() : $this->onCreate();
    }

}
