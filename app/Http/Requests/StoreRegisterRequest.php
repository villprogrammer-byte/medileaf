<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'mobile' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'dob' => ['required', 'date', 'before:-18 years'],
            'age_confirm' => ['required', 'accepted'],
            'terms' => ['required', 'accepted'],
            'health_consent' => ['required', 'accepted'],
            'cf-turnstile-response' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'dob.before' => 'You must be at least 18 years old to register.',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
        ];
    }
}