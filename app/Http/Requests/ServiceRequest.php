<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:99999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            // 'duration' => 'required',
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
            'name.max' => 'Máximo de caracteres :max',
            'description.max' => 'máximo de caracteres :max',
            'price.required' => 'O campo preço deve ser preenchido',
            'price.numeric' => 'Preço deve um número',
            'price.min' => 'Valor minímo :min',
            'price.max' => 'Valor máximo :max',
            'price.regex' => 'Formato de preço inválido',
        ];
    }
}
