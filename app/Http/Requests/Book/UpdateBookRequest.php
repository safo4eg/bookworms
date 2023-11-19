<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'image.dimensions' => 'Minimum image width - 1080px, maximum height - 1350px',
            'date_of_writing.date' => 'Invalid date format. The format should be YYYY-MM-DD'
        ];
    }

    public function rules(): array
    {
        return [
            'image' => ['nullable', 'image', 'dimensions:min_width=1080,min_height=1350'],
            'title' => ['nullable', 'string', 'max:128'],
            'desc' => ['nullable', 'string', 'max:1024'],
            'date_of_writing' => ['nullable', 'string', 'date:YY-MM-DD'],
            'authors' => ['nullable'],
            'genres' => ['nullable']
        ];
    }
}
