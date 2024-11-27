<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XRayRequest extends FormRequest
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
    protected function onCreateOrUpdate() : array
    {
        $commonRules = [
            'title'      => 'nullable|string|max:255',
            'cost'       => 'required|numeric|min:0',
            'timing'     => 'required|in:before,after,in_between',
            'notes'      => 'nullable|string|max:255',
            'patient_id' => 'required|exists:patients,id',
        ];

        // Add 'sometimes' validation for the 'image' field in PATCH or PUT requests
        $imageRule = $this->isMethod('patch') || $this->isMethod('put') ?
            'sometimes|nullable|image|mimes:png,jpg,jpeg,gif,webp' :
            'required|image|mimes:png,jpg,jpeg,gif,webp';

        return array_merge($commonRules, ['image' => $imageRule]);
    }

    public function messages()
    {
        return [
            'patient_id.exists' => 'The selected patient does not exist.',
            'image.required'    => 'The X-ray image is required.',
            'image.image'       => 'The image field must be an image.',
            'image.mimes'       => 'The image must be a file of type: png, jpg, jpeg, gif, webp.'
        ];
    }

    public function rules(): array
    {
        return $this->onCreateOrUpdate();
    }
}
