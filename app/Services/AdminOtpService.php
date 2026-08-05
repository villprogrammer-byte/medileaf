<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\AdminLoginOtp;
use Illuminate\Support\Facades\Hash;

class AdminOtpService
{
    private const OTP_EXPIRY_MINUTES = 10;

    public function generate(Admin $admin): string
    {
        $this->invalidatePreviousOtps($admin);

        $otp = (string) random_int(100000, 999999);

        AdminLoginOtp::create([
            'admin_id' => $admin->id,
            'otp' => Hash::make($otp),
            'expires_at' => now()->addMinutes(self::OTP_EXPIRY_MINUTES),
            'is_used' => false,
        ]);

        return $otp;
    }

    public function verify(Admin $admin, string $otp): bool
    {
        $loginOtp = AdminLoginOtp::query()
            ->where('admin_id', $admin->id)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->latest('id')
            ->first();

        if (!$loginOtp || !Hash::check($otp, $loginOtp->otp)) {
            return false;
        }

        $loginOtp->update([
            'is_used' => true,
        ]);

        return true;
    }

    public function invalidatePreviousOtps(Admin $admin): void
    {
        AdminLoginOtp::query()
            ->where('admin_id', $admin->id)
            ->where('is_used', false)
            ->update([
                'is_used' => true,
            ]);
    }

    public function expiryMinutes(): int
    {
        return self::OTP_EXPIRY_MINUTES;
    }
}