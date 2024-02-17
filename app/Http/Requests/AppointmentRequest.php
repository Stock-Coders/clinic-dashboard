<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class AppointmentRequest extends FormRequest
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
            'appointment_reason' => 'required|in:examination,reexamination',
            'diagnosis'          => 'required|string|max:255',
            'status'             => 'required|in:scheduled,completed,canceled',
            'cost'               => 'required|numeric|min:0',
            'appointment_date'   => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d')], // Restriction for choosing the past dates, only allowed to choose today or any future date
            'appointment_time'   => 'required|custom_time_format',
            'patient_id'         => 'required|exists:patients,id',
            'doctor_id'          => 'required|exists:users,id',
        ];
        if(auth()->user()->user_type == 'doctor' || auth()->user()->user_type == 'developer'){
            $rules['diagnosis'] = 'required|string|max:255';

        }elseif(auth()->user()->user_type == 'employee'){
            $rules['diagnosis'] = 'nullable|string|max:255';
        }
        else{
            return abort(403);
        }
        return $rules;

    }

    public function messages()
    {
        return [
            'appointment_date.after_or_equal' => 'The "Date" must be today or any future date.',
            'patient_id.exists'               => 'The selected patient does not exist.',
            'doctor_id.exists'                => 'The selected doctor does not exist.'
        ];
    }

    public function rules(): array
    {
        return $this->onCreateOrUpdate();
    }
}
