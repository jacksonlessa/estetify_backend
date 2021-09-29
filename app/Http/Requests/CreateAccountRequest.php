<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->account_id)
            return false;

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
            'name' => 'required',
            'document' => [
                'required',
                'max:18'
            ],
            'activity' => 'required',
            'other_activity' =>  "required_if:activity,Outro",
            'phone' => [
                'required',
                'max:15'
            ],
        ];
    }
}
