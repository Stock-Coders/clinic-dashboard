<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class AnalysisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function onCreateOrUpdate(){
        // Register the custom rule (for accepting both validations "date_format:h:i" and "date_format:h:i:s" time formats)
        Validator::extend('custom_time_format', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?:2[0-3]|[01][0-9]):[0-5][0-9](?::[0-5][0-9])?$/', $value);
        });

        return[
            'medical_lab_name' => 'required|string|max:255',
            'analysis_type'    => 'required|string|max:255',
            'analysis_date'    => 'required|date',
            'analysis_time'    => 'required|custom_time_format',
            'recommendations'  => 'nullable|string|max:765',
            'notes'            => 'nullable|string|max:765',
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'patient_id.exists' => 'The selected patient does not exist.',
            'doctor_id.exists'  => 'The selected doctor does not exist.'
        ];
    }

    public function rules(): array
    {
        return $this->onCreateOrUpdate();
    }
}
