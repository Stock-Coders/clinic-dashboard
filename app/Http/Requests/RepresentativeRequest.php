<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RepresentativeRequest extends FormRequest
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
            'name'            => 'required|string|max:255|unique:representatives,name',
            'description'     => 'nullable|string|max:765',
            'address'         => 'nullable|string|max:255',
            'email'           => 'nullable|email|max:255|unique:representatives,email',
            'website'         => 'nullable|url',
            'phone'           => 'required|digits:11|numeric|unique:representatives,phone',
            'secondary_phone' => 'nullable|digits:11|numeric|unique:representatives,secondary_phone',
        ];
}

   /**
    * @return array
    */

   protected function onUpdate() : array
   {
        $id = $this->route('representative'); // Assuming your route parameter is named 'representative'

        return [
            'name'            => ['required', 'string', 'max:255', Rule::unique('representatives', 'name')->ignore($id)],
            'description'     => ['nullable', 'string', 'max:765'],
            'address'         => ['nullable', 'string', 'max:255'],
            'email'           => ['nullable', 'email', 'max:255', Rule::unique('representatives', 'email')->ignore($id)],
            'website'         => ['nullable', 'url'],
            'phone'           => ['required', 'numeric', 'digits:11', Rule::unique('representatives', 'phone')->ignore($id)],
            'secondary_phone' => ['nullable', 'numeric', 'digits:11', Rule::unique('representatives', 'secondary_phone')->ignore($id)],
        ];
   }

    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ?
            $this->onUpdate() : $this->onCreate();
    }
}
