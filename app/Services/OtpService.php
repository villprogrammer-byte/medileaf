<?php

namespace App\Services;

use App\Models\LoginOtp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OtpService
{
    /**
     * OTP expiry duration in minutes.
     */
    private const OTP_EXPIRY_MINUTES = 10;

    /**
     * Generate and store a fresh OTP for the user.
     */
    public function generate(User $user): string
    {
        $this->invalidatePreviousOtps($user);

        $otp = (string) random_int(100000, 999999);

        LoginOtp::create([
            'user_id' => $user->id,
            'otp' => Hash::make($otp),
            'expires_at' => now()->addMinutes(self::OTP_EXPIRY_MINUTES),
            'is_used' => false,
        ]);

        return $otp;
    }

    /**
     * Verify the OTP entered by the user.
     */
    public function verify(User $user, string $otp): bool
    {
        $loginOtp = LoginOtp::query()
            ->where('user_id', $user->id)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->latest('id')
            ->first();

        if (!$loginOtp) {
            return false;
        }

        if (!Hash::check($otp, $loginOtp->otp)) {
            return false;
        }

        $loginOtp->update([
            'is_used' => true,
        ]);

        return true;
    }

    /**
     * Mark all previous unused OTPs as used.
     */
    public function invalidatePreviousOtps(User $user): void
    {
        LoginOtp::query()
            ->where('user_id', $user->id)
            ->where('is_used', false)
            ->update([
                'is_used' => true,
            ]);
    }

    /**
     * Remove old expired OTP records.
     */
    public function deleteExpiredOtps(): int
    {
        return LoginOtp::query()
            ->where('expires_at', '<', now())
            ->delete();
    }

    /**
     * Return OTP expiry time in minutes.
     */
    public function expiryMinutes(): int
    {
        return self::OTP_EXPIRY_MINUTES;
    }
}