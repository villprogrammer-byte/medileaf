<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Password Reset Verification | MediLeaf Health</title>
</head>

<body style="
    margin:0;
    padding:0;
    width:100%;
    background:#f4f7f4;
    font-family:Arial, Helvetica, sans-serif;
    color:#243326;
    -webkit-text-size-adjust:100%;
    -ms-text-size-adjust:100%;
">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="
            width:100%;
            margin:0;
            padding:0;
            background:#f4f7f4;
            border-collapse:collapse;
        ">
        <tr>
            <td align="center" style="padding:40px 15px;">

                {{-- =========================================
                EMAIL CARD
                ========================================== --}}
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="
                        width:100%;
                        max-width:600px;
                        background:#ffffff;
                        border-radius:16px;
                        overflow:hidden;
                        border-collapse:separate;
                        box-shadow:0 8px 30px rgba(0,0,0,0.06);
                    ">

                    {{-- =========================================
                    HEADER
                    ========================================== --}}
                    <tr>
                        <td align="center" style="
                                padding:30px 30px 24px;
                                background:#f7fbf6;
                                border-bottom:1px solid #e6eee4;
                            ">

                            {{-- Security Icon --}}
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center"
                                style="margin:0 auto 14px;">
                                <tr>
                                    <td align="center" valign="middle" width="54" height="54" style="
                                            width:54px;
                                            height:54px;
                                            background:#31a050;
                                            border-radius:50%;
                                            color:#ffffff;
                                            font-size:25px;
                                            font-weight:bold;
                                            line-height:54px;
                                            text-align:center;
                                        ">
                                        ✓
                                    </td>
                                </tr>
                            </table>

                            <h1 style="
                                    margin:0;
                                    padding:0;
                                    font-size:24px;
                                    line-height:32px;
                                    font-weight:700;
                                    color:#243326;
                                ">
                                Password Reset Verification
                            </h1>

                            <p style="
                                    margin:8px 0 0;
                                    padding:0;
                                    font-size:14px;
                                    line-height:22px;
                                    color:#667085;
                                ">
                                Secure verification from MediLeaf Health
                            </p>

                        </td>
                    </tr>


                    {{-- =========================================
                    EMAIL CONTENT
                    ========================================== --}}
                    <tr>
                        <td style="
                                padding:32px 40px;
                            ">

                            <h2 style="
                                    margin:0 0 14px;
                                    padding:0;
                                    font-size:20px;
                                    line-height:28px;
                                    font-weight:700;
                                    color:#243326;
                                ">
                                Hello {{ $name }},
                            </h2>

                            <p style="
                                    margin:0 0 24px;
                                    padding:0;
                                    font-size:15px;
                                    line-height:24px;
                                    color:#667085;
                                ">
                                We received a request to reset your MediLeaf password.
                                Use the verification code below to continue.
                            </p>


                            {{-- =========================================
                            OTP BOX
                            ========================================== --}}
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="
                                    width:100%;
                                    margin:0 0 24px;
                                    background:#f3f8f2;
                                    border:1px solid #dcebd8;
                                    border-radius:12px;
                                    border-collapse:separate;
                                ">
                                <tr>
                                    <td align="center" style="
                                            padding:22px 15px 8px;
                                            font-size:12px;
                                            line-height:18px;
                                            font-weight:700;
                                            text-transform:uppercase;
                                            letter-spacing:1px;
                                            color:#667085;
                                        ">
                                        Verification Code
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" style="
                                            padding:0 15px 24px;
                                            font-size:36px;
                                            line-height:44px;
                                            font-weight:800;
                                            letter-spacing:8px;
                                            color:#31a050;
                                        ">
                                        {{ $otp }}
                                    </td>
                                </tr>
                            </table>


                            {{-- Expiry --}}
                            <p style="
                                    margin:0 0 16px;
                                    padding:0;
                                    font-size:15px;
                                    line-height:24px;
                                    color:#667085;
                                ">
                                This verification code will expire in
                                <strong style="color:#243326;">
                                    10 minutes
                                </strong>.
                            </p>


                            {{-- Ignore Message --}}
                            <p style="
                                    margin:0;
                                    padding:0;
                                    font-size:14px;
                                    line-height:23px;
                                    color:#667085;
                                ">
                                If you didn't request a password reset, you can safely
                                ignore this email. Your password will remain unchanged.
                            </p>

                        </td>
                    </tr>


                    {{-- =========================================
                    SECURITY MESSAGE
                    ========================================== --}}
                    <tr>
                        <td style="
                                padding:0 40px 30px;
                            ">

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="
                                    width:100%;
                                    background:#f8faf8;
                                    border-radius:10px;
                                    border-collapse:separate;
                                ">
                                <tr>
                                    <td align="center" style="
                                            padding:14px 16px;
                                            font-size:13px;
                                            line-height:20px;
                                            color:#667085;
                                        ">
                                        🔒
                                        For your security, never share this verification
                                        code with anyone.
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>


                    {{-- =========================================
                    FOOTER
                    ========================================== --}}
                    <tr>
                        <td align="center" style="
                                padding:22px 30px;
                                background:#243326;
                            ">

                            <p style="
                                    margin:0 0 5px;
                                    padding:0;
                                    font-size:14px;
                                    line-height:22px;
                                    font-weight:700;
                                    color:#ffffff;
                                ">
                                MediLeaf Health
                            </p>

                            <p style="
                                    margin:0;
                                    padding:0;
                                    font-size:12px;
                                    line-height:20px;
                                    color:#cbd5c8;
                                ">
                                © {{ date('Y') }} MediLeaf Health.
                                All rights reserved.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>