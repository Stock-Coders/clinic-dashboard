<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class PaymentRequest extends FormRequest
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

        $rules = [
            'payment_method' => 'nullable|in:cash,vodafone_cash,credit_card',
            'discount'       => 'nullable|numeric|min:0',
            'payment_date'   => 'required|date',
            'payment_time'   => 'required|custom_time_format',
            'patient_id'     => 'required|exists:patients,id',
            'xray_id'        => 'nullable|array',
            'xray_id.*'      => 'nullable|exists:xrays,id',
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $id = $this->route('payment');
            $rules['appointment_id']            = 'required|exists:appointments,id|unique:payments,appointment_id,' . $id;
            $rules['treatment_id']              = 'nullable|exists:treatments,id|unique:payments,treatment_id,' . $id;
            $rules['prescription_treatment_id'] = 'nullable|exists:prescriptions_treatments,id|unique:payments,prescription_treatment_id,' . $id;
            // $rules['xray_id']                   = 'nullable|exists:xrays,id|unique:payments,xray_id,' . $id;
        }
        else{
            $rules['appointment_id']            = 'required|exists:appointments,id|unique:payments,appointment_id';
            $rules['treatment_id']              = 'nullable|exists:treatments,id|unique:payments,treatment_id';
            $rules['prescription_treatment_id'] = 'nullable|exists:prescriptions_treatments,id|unique:payments,prescription_treatment_id';
            // $rules['xray_id']                   = 'nullable|exists:xrays,id|unique:payments,xray_id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'appointment_id.unique'            => 'The selected appointment has already been taken.',
            'treatment_id.unique'              => 'The selected treatment has already been taken.',
            'prescription_treatment_id.unique' => 'The selected treatment\'s prescription has already been taken.',
            // 'xray_id.unique'                   => 'The selected X-ray has already been taken.',

            'appointment_id.exists'            => 'The selected appointment does not exist.',
            'treatment_id.exists'              => 'The selected treatment does not exist.',
            'prescription_treatment_id.exists' => 'The selected treatment\'s prescription does not exist.',
            'xray_id.exists'                   => 'The selected X-ray does not exist.',
            'patient_id.exists'                => 'The selected patient does not exist.',
        ];
    }

    public function rules(): array
    {
        return $this->onCreateOrUpdate();
    }
}
