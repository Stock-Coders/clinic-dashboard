<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    protected function onCreate() : array
    {
    return [
            'title'              => 'required|string|max:255|unique:materials,title',
            'description'        => 'nullable|string|max:765',
            'quantity'           => 'nullable|integer',
            'cost'               => 'required|numeric',
            'expiration_date'    => 'required|date',
            'representative_id'  => 'required|exists:representatives,id',
        ];
}

   /**
    * @return array
    */

   protected function onUpdate() : array
   {
        $id = $this->route('material'); // Assuming your route parameter is named 'material'

        return [
            'title'             => ['required', 'string', 'max:255', Rule::unique('materials', 'title')->ignore($id)],
            'description'       => 'nullable|string|max:765',
            'quantity'          => 'nullable|integer',
            'cost'              => 'required|numeric|min:0',
            'expiration_date'   => 'required|date',
            'representative_id' => 'required|exists:representatives,id'
        ];
   }

   public function messages()
    {
        return [
            'representative_id.exists' => 'The selected representative does not exist.',
        ];
    }

    public function rules(): array
    {
        return request()->isMethod('put') || request()->isMethod('patch') ?
            $this->onUpdate() : $this->onCreate();
    }
}
