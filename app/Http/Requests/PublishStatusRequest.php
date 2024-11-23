<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublishStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'numeric|required|exists:films,id',
            'status' => 'boolean',
        ];
    }
}
