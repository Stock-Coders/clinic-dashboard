<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicalHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function onCreateOrUpdate(){
        $rules = [
            'patient_name'              => 'nullable|string|max:255',
            'notes'                     => 'nullable|string|max:765'
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $id = $this->route('medical_history');
            $rules['appointment_id']            = 'required|exists:appointments,id|unique:medical_histories,appointment_id,' . $id;
            $rules['prescription_id']           = 'required|exists:prescriptions,id|unique:medical_histories,prescription_id,' . $id;
            $rules['treatment_id']              = 'required|exists:treatments,id|unique:medical_histories,treatment_id,' . $id;
            $rules['prescription_treatment_id'] = 'required|exists:prescriptions_treatments,id|unique:medical_histories,prescription_treatment_id,' . $id;

        }
        else{
            $rules['appointment_id']            = 'required|exists:appointments,id|unique:medical_histories,appointment_id';
            $rules['prescription_id']           = 'required|exists:prescriptions,id|unique:medical_histories,prescription_id';
            $rules['treatment_id']              = 'required|exists:treatments,id|unique:medical_histories,treatment_id';
            $rules['prescription_treatment_id'] = 'required|exists:prescriptions_treatments,id|unique:medical_histories,prescription_treatment_id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'appointment_id.unique'            => 'The selected appointment has already been taken.',
            'prescription_id.unique'           => 'The selected prescription has already been taken.',
            'treatment_id.unique'              => 'The selected treatment has already been taken.',
            'prescription_treatment_id.unique' => 'The selected treatment\'s prescription has already been taken.',
            'appointment_id.exists'            => 'The selected appointment does not exist.',
            'prescription_id.exists'           => 'The selected prescription does not exist.',
            'treatment_id.exists'              => 'The selected treatment does not exist.',
            'prescription_treatment_id.exists' => 'The selected treatment\'s prescription does not exist.'
        ];
    }

    public function rules(): array
    {
        return $this->onCreateOrUpdate();
    }
}
