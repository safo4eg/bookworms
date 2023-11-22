<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'rating.in' => 'The rating must contain values from 1 to 5 inclusive'
        ];
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', Rule::in([1, 2, 3, 4, 5])]
        ];
    }
}
