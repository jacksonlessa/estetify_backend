<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateScheduleRequest extends FormRequest
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
            "professional_id" => "required",
            "scheduled_at" => "required|date",
            // "service.id" => "required|integer",
            "services.*" => [
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
