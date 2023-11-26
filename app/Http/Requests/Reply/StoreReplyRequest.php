<?php

namespace App\Http\Requests\Reply;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reply_id' => ['nullable', 'exists:replies,id'],
            'text' => ['required', 'string', 'max:1024']
        ];
    }
}
