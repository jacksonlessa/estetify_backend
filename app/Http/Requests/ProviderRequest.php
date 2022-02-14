<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProviderRequest extends FormRequest
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
            'account_id' => 'required',
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
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
}
