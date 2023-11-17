<?php

namespace App\Http\Requests\Author;

trait RuleTrait
{
    public function messages()
    {
        return [
            'date_of_birth.date' => 'Invalid date format. The format should be YYYY-MM-DD',
            'date_of_death.date' => 'Invalid date format. The format should be YYYY-MM-DD'
        ];
    }
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:64'],
            'surname' => ['nullable', 'string', 'max:64'],
            'patronymic' => ['nullable', 'string', 'max:64'],
            'date_of_birth' => ['nullable', 'string', 'date:YY-MM-DD'],
            'date_of_death' => ['nullable', 'string', 'date:YY-MM-DD'],
            'origin' => ['nullable', 'string', 'max:64'],
            'desc' => ['nullable', 'string', 'max:1024']
        ];
    }
}
