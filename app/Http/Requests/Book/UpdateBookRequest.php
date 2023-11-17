<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{

    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'image' => ['nullable', 'image', 'dimensions:min_width=1080,min_height=1350'],
            'title' => ['nullable', 'string', 'max:128'],
            'desc' => ['nullable', 'string', 'max:1024'],
            'date_of_writing' => ['nullable', 'string', 'date:YY-MM-DD']
        ];
    }
}
