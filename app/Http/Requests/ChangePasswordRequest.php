<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         * old_password rule is defined in Providers\RayServiceProvider
         */
        return [
            'oldpassword' => 'required|old_password:' . Auth::user()->password,
            'password' => 'required|min:3',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'oldpassword.old_password' => 'Wrong password, please try again.',
        ];
    }
}
