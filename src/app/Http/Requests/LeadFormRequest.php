<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return static::leadRules();
    }

    public function messages(): array
    {
        return static::leadMessages();
    }

    public static function leadRules(): array
    {
        return [
            'name'    => ['required', 'string', 'min:2', 'max:100'],
            'phone'   => ['required', 'string', 'regex:/^\+?[\d\s\-\(\)]{7,20}$/'],
            'email'   => ['required', 'email:rfc'],
            'message' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public static function leadMessages(): array
    {
        return [
            'name.required'  => 'Please enter your name.',
            'name.min'       => 'Name must be at least 2 characters.',
            'phone.required' => 'Please enter your phone number.',
            'phone.regex'    => 'Please enter a valid phone number (e.g. +380671234567).',
            'email.required' => 'Please enter your email address.',
            'email.email'    => 'Please enter a valid email address.',
        ];
    }
}
