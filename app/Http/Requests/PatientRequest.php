<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
        public function onCreate(){
            return[
                'first_name'      => 'required|string|max:255',
                'last_name'       => 'required|string|max:255',
                'chief_complaint' => 'required|in:badly_aesthetic,severe_pain,mastication',
                'chronic_disease' => 'nullable|string|max:255',
                'image'           => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2500', // max 2500 KiloBytes (2.5 MB)
                'email'           => 'nullable|email|max:255|unique:patients,email',
                'phone'           => 'required|numeric|digits:11|unique:patients,phone',
                'emergency_phone' => 'nullable|numeric|digits:11|unique:patients,emergency_phone',
                'whatsapp'        => 'nullable|string|max:255',
                'dob'             => 'date|required',
                'gender'          => 'required|in:male,female',
                'address'         => 'required|string|max:255',
                // 'insurance_info'  => 'nullable|string|max:255'
            ];
        }

        public function onUpdate(){

            $id = $this->route('patient');

            return[
                'first_name'      => 'required|string|max:255',
                'last_name'       => 'required|string|max:255',
                'chief_complaint' => 'required|in:badly_aesthetic,severe_pain,mastication',
                'chronic_disease' => 'nullable|string|max:255',
                'image'           => 'nullable|sometimes|image|mimes:png,jpg,jpeg,svg,webp|max:2500', // max 2500 KiloBytes (2.5 MB)
                'email'           => ['nullable', 'email', 'max:255', Rule::unique('patients' ,'email')->ignore($id)],
                'phone'           => ['required', 'numeric','digits:11', Rule::unique('patients' ,'phone')->ignore($id)],
                'emergency_phone' => ['nullable', 'numeric','digits:11', Rule::unique('patients' ,'emergency_phone')->ignore($id)],
                'whatsapp'        => 'nullable|string|max:255',
                'dob'             => 'required|date',
                'gender'          => 'required|in:male,female',
                'address'         => 'required|string|max:255',
                // 'insurance_info'  => 'nullable|string|max:255'
            ];
        }

        public function messages()
        {
            return [
                'image.image' => 'The image field must be an image.',
                'image.mimes' => 'The image must be a file of type: png, jpg, jpeg, svg, webp.'
            ];
        }

        public function rules(): array
        {
            return request()->isMethod('put') || request()->isMethod('patch') ?
                $this->onUpdate() : $this->onCreate();
        }
}
