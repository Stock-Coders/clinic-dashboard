<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

   /**
    * @return array
    */

    // protected function onCreate() : array
    // {
    //         return [
    //             'name'            => 'required|string|max:255',
    //             'avatar'          => 'required|image|mimes:jpeg,png,jpg',
    //             'bio'             => 'nullable|string|max:765',
    //             'gender'          => 'nullable|in:male,female', // validation handled in the controller
    //             'address'         => 'nullable|string|max:765',
    //             'dob'             => 'nullable|date',
    //             'secondary_phone' => 'nullable|digits:11|numeric', // validation handled in the controller
    //             'whatsapp'        => 'nullable||string|max:255',
    //             'facebook'        => 'nullable||string|max:255',
    //             'user_id'         => 'required|exists:users,id'
    //         ];
    // }

    // protected function onUpdate() : array
    // {
    //         return [
    //             'name'            => 'required|string|max:255',
    //             'avatar'          => 'nullable|sometimes|image|mimes:jpeg,png,jpg',
    //             'bio'             => 'nullable|string|max:765',
    //             'gender'          => 'nullable|in:male,female', // validation handled in the controller
    //             'address'         => 'nullable|string|max:765',
    //             'dob'             => 'nullable|date',
    //             'secondary_phone' => 'nullable|digits:11|numeric', // validation handled in the controller
    //             'whatsapp'        => 'nullable||string|max:255',
    //             'facebook'        => 'nullable||string|max:255',
    //             'user_id'         => 'required|exists:users,id'
    //         ];
    // }

    // public function rules(): array
    // {
    //     return request()->isMethod('put') || request()->isMethod('patch') ?
    //             $this->onUpdate() : $this->onCreate();
    // }

    protected function onCreateOrUpdate() : array
    {
            return [
                'name'            => 'required|string|max:255',
                'avatar'          => 'nullable|sometimes|mimes:jpeg,png,jpg|max:2500', // max 2500 KiloBytes (2.5 MB)
                'bio'             => 'nullable|string|max:765',
                'gender'          => 'nullable|in:male,female', // validation handled in the controller
                'address'         => 'nullable|string|max:765',
                'dob'             => 'nullable|date',
                'secondary_phone' => 'nullable|digits:11|numeric', // validation handled in the controller
                'whatsapp'        => 'nullable|string|max:255',
                'facebook'        => 'nullable|string|max:255',
                'user_id'         => 'required|exists:users,id'
            ];
    }

    public function rules(): array
    {
        return $this->onCreateOrUpdate();

        // return request()->isMethod('put') || request()->isMethod('patch') ?
        //         $this->onUpdate() : $this->onCreate();
    }

}
