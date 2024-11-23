<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFilmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|required|max:128',
            'published' => 'boolean',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'genres' => 'array',
        ];
    }
}
