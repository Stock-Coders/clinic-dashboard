<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class ReceiptRequest extends FormRequest
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
            // 'total_amount'    => 'required|float',
            'receipt_date'    => 'required|date',
            'receipt_time'    => 'required|custom_time_format',
            'billing_details' => 'nullable|string|max:765'
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $id = $this->route('receipt');
            $rules['payment_id'] = 'required|exists:payments,id|unique:receipts,payment_id,' . $id;
        } else{
            $rules['payment_id'] = 'required|exists:payments,id|unique:receipts,payment_id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'payment_id.exists' => 'The selected payment does not exist.',
            'payment_id.unique' => 'The selected payment has already been taken.'
        ];
    }

    public function rules(): array
    {
        return $this->onCreateOrUpdate();
    }
}
