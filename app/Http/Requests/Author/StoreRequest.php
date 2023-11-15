<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    use RuleTrait;
    public function authorize(): bool
    {
        return true;
    }
}
