<?php

namespace App\Http\Requests;

use App\Rules\HasWebhook;
use Illuminate\Foundation\Http\FormRequest;

class SendSMSRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'recipient_id' => [
                'required',
                'numeric',
                'exists:users,id',
                new HasWebhook,
            ],
            'message' => [
                'required',
                'string',
                'max:1600'
            ],
            'from' => [
                'required',
                'string',
            ]
        ];
    }
}
