<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'password.regex' => 'The password field must contain the characters A-Z, 0-9, %, $, #, or @.'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string', 'min:6', 'max:32', 'alpha_dash', 'unique:users,login'],
            'email' => ['nullable', 'string', 'max:256', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:32', 'regex:/^[0-9A-z%$#@]+$/', 'confirmed']
        ];
    }
}
