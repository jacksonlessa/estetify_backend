<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            "user_id" => "required",
            "scheduled_at" => "required|date",
            "status" => "required",
            "total" =>  [
                'required',
                'numeric',
                'min:0',
                'max:9999999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
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
            "services" => [
                'required',
                'array',
            ]

        ];
    }
}
