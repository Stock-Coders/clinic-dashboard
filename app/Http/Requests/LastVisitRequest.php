<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LastVisitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function onCreate() : array
    {
    return [
            'last_visit_date' => 'required|date',
            'patient_id'      => 'required|exists:patients,id',
        ];
    }

    public function messages()
    {
        return [
            'patient_id.exists' => 'The selected patient does not exist.'
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ?
            $this->onCreate() : $this->onCreate();
    }
}
