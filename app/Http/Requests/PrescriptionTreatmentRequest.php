<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionTreatmentRequest extends FormRequest
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
            // 'prescription' => 'required|string|max:765',
            'allergy'      => 'nullable|string|max:255',
            'next_visit'   => ['nullable', 'date', 'after_or_equal:' . now()->format('Y-m-d')] // Restriction for choosing the past dates, only allowed to choose today or any future date

        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $id = $this->route('prescriptions_treatment');
            $rules['treatment_id'] = 'required|exists:treatments,id|unique:prescriptions_treatments,treatment_id,' . $id;

        }
        else{
            $rules['treatment_id'] = 'required|exists:treatments,id|unique:prescriptions_treatments,treatment_id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'treatment_id.exists'       => 'The selected treatment does not exist.',
            'treatment_id.unique'       => 'The selected treatment has already been taken.',
            'next_visit.after_or_equal' => 'The "Next Visit" date must be today or any future date.'
        ];
    }

    public function rules(): array
    {
        return $this->onCreateOrUpdate();
    }
}
