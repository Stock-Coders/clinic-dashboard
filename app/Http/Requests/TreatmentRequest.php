<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class TreatmentRequest extends FormRequest
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

    public function onCreateOrUpdate(){
        // Register the custom rule (for accepting both validations "date_format:h:i" and "date_format:h:i:s" time formats)
        Validator::extend('custom_time_format', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?:2[0-3]|[01][0-9]):[0-5][0-9](?::[0-5][0-9])?$/', $value);
        });

        $rules = [
            'procedure_name' => 'required|string|max:255',
            'treatment_type' => 'required|in:surgical,medical,preventive',
            'status'         => 'required|in:scheduled,completed,canceled',
            'cost'           => 'required|numeric|min:0',
            'treatment_date' => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d')], // Restriction for choosing the past dates, only allowed to choose today or any future date
            'treatment_time' => 'required|custom_time_format',
            'notes'          => 'nullable|string|max:765',
        ];

        // The other validations for "prescription_id" and "appointment_id" are handled natively in the controller (DashboardTreatmentController.php)
            if ($this->isMethod('patch') || $this->isMethod('put')) {
                $id = $this->route('treatment');
                $rules['prescription_id'] = 'nullable|unique:treatments,prescription_id,' . $id;
                $rules['appointment_id']  = 'nullable|unique:treatments,appointment_id,' . $id;

            }
            else{
                $rules['prescription_id'] = 'nullable|unique:treatments,prescription_id';
                $rules['appointment_id']  = 'nullable|unique:treatments,appointment_id';
            }

        return $rules;
    }

    public function messages()
    {
        return [
            // 'prescription_id.unique' => 'The selected prescription has already been taken.',
            'treatment_date.after_or_equal' => 'The "Date" must be today or any future date.',
            'appointment_id.unique'         => 'The selected appointment has already been taken.'
            // 'materials.exists'       => 'The selected material does not exist.'
        ];
    }

    public function rules(): array
    {
        return $this->onCreateOrUpdate();
    }
}
