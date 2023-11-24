<?php

namespace App\Http\Requests\Critique;

use Illuminate\Foundation\Http\FormRequest;

class StoreCritiqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'text' => ['required', 'min:5', 'max:2048']
        ];
    }
}
