<?php

namespace App\Http\Requests\Critique;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCritiqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
