<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!in_array(Auth::user()->role, ["admin","master"])){
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=> 'required|string',
            'email'=> [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($this->id)
            ],
            'password' => 'sometimes|required|string|confirmed',
        ];
    }
}
