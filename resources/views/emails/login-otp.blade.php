<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>MediLeaf OTP</title>

</head>

<body style="font-family:Arial;padding:40px;background:#f5f5f5;">

    <div style="max-width:600px;background:#fff;margin:auto;padding:40px;border-radius:12px;">

        <h2>Hello {{ $name }},</h2>

        <p>

            Use the verification code below to continue your login.

        </p>

        <div
            style="font-size:38px; font-weight:bold; letter-spacing:8px; text-align:center; padding:25px; background:#f3f3f3; border-radius:10px;margin:30px 0;">

            {{ $otp }}

        </div>

        <p>

            This OTP expires in <strong>10 minutes</strong>.

        </p>

        <p>

            If you didn't request this login you can safely ignore this email.

        </p>

        <hr>

        <p>

            © {{ date('Y') }} MediLeaf Health

        </p>

    </div>

</body>

</html>