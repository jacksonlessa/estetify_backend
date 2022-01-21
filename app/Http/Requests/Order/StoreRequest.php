<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            //
            "client_id" => "required",
            // "professional_id" => "required",
            "scheduled_at" => "required|date",
            "status" => "required",
            "total" =>  [
                'required',
                'numeric',
                'min:0',
                'max:9999999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            "observation" => [
                "nullable",
                "string",
                "max:255"
            ],
            "payment_method" => "required_if:status,closed",
            // "service.id" => "required|integer",
            "services.*.price" => [
                'required',
                'numeric',
                'min:0',
                'max:99999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            "services.*.original_price" => [
                'required',
                'numeric',
                'min:0',
                'max:99999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            "services.*.professional_id" => [
                'sometimes',
                'required',
                'numeric',
                'min:0',
                'max:99999.99'
            ],
            "services" => [
                'required',
                'array',
            ]

        ];
    }

    public function messages()
    {
        return [
            'payment_method.required_if' => 'O campo forma de pagamento é obrigatório quando status for Finalizado.',
        ];
    }
}
