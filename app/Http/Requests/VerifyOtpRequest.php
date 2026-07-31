<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules.
     */
    public function rules(): array
    {
        return [
            'otp' => [
                'required',
                'digits:6',
            ],
        ];
    }

    /**
     * Custom Messages.
     */
    public function messages(): array
    {
        return [
            'otp.required' => 'Please enter the verification code.',
            'otp.digits' => 'OTP must be exactly 6 digits.',
        ];
    }
}