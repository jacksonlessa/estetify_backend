<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        return [
            'name' => 'required',
            'account_id' => 'required',
            'birthdate' => 'nullable',
            'email' => [
                'nullable',
                // 'required',
                'email'
            ],
            'phone' => [
                'nullable',
                'max:15'
            ],
            'document' => [
                'nullable',
                'max:18'
            ],
            'address' => [
                'nullable',
                'max:255'
            ],
            'neighborhood' => [
                'nullable',
                'max:50'
            ],
            'city' => [
                'nullable',
                'max:50'
            ],
            'state' => [
                'nullable',
                'max:2'
            ],
            'postal_code' => [
                'nullable',
                'max:9'
            ],
        ];
    }    
}
