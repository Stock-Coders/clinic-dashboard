<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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
            'prescription' => 'required|string|max:2000',
            'allergy'      => 'nullable|string|max:255',
            'next_visit'   => ['nullable', 'date', 'after_or_equal:' . now()->format('Y-m-d')] // Restriction for choosing the past dates, only allowed to choose today or any future date
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $id = $this->route('prescription');
            $rules['appointment_id']  = 'required|exists:appointments,id|unique:prescriptions,appointment_id,' . $id;

        }
        else{
            $rules['appointment_id']  = 'required|exists:appointments,id|unique:prescriptions,appointment_id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'appointment_id.unique'     => 'The selected appointment has already been taken.',
            'appointment_id.exists'     => 'The selected appointment does not exist.',
            'next_visit.after_or_equal' => 'The "Next Visit" date must be today or any future date.'
        ];
    }

    public function rules(): array
    {
        return $this->onCreateOrUpdate();
    }
}
