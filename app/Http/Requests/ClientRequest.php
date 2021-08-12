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
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O campo nome deve ser preenchido',
            'account_id.required' => 'Deve ser fornecido uma conta',
            'email.required' => 'O campo e-mail deve ser preenchido',
            'email.email' => 'E-mail deve conter um formato válido',
            'document.max' => 'Documento deve ter no máximo :max caracteres'
        ];
    }
}
