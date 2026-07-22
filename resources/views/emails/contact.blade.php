<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Contact Enquiry</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; color:#333; background:#f7f7f7; padding:20px;">

    <table width="700" align="center" cellpadding="0" cellspacing="0"
        style="background:#fff;border:1px solid #e5e5e5;border-radius:8px;">

        <tr>
            <td style="background:#2f7d32;color:#fff;padding:20px;text-align:center;">

                <img src="http://127.0.0.1:8000/img/medileaf-white-logo.png" alt="MediLeaf Health" width="150"
                    style="display:block;margin:0 auto 15px auto;max-width:150px;height:auto;">

                <h2 style="margin:0;text-align:center;">New Contact Enquiry</h2>

            </td>
        </tr>

        <tr>
            <td style="padding:25px;">

                <p>A new contact enquiry has been submitted through the <strong>MediLeaf Health</strong> website.</p>

                <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;">

                    <tr>
                        <td width="35%"><strong>First Name</strong></td>
                        <td>{{ $data['first_name'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><strong>Last Name</strong></td>
                        <td>{{ $data['last_name'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{ $data['email'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><strong>Phone</strong></td>
                        <td>{{ $data['phone'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><strong>Reason</strong></td>
                        <td>{{ $data['reason'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><strong>Message</strong></td>
                        <td>{{ $data['message'] ?? '' }}</td>
                    </tr>

                </table>

                <br>

                <p>
                    <strong>Submitted On:</strong>
                    {{ now()->format('d M Y h:i A') }}
                </p>

            </td>
        </tr>

        <tr>
            <td style="background:#f5f5f5;padding:15px;font-size:13px;color:#666;text-align:center;">
                This email was automatically generated from the MediLeaf Health website.
            </td>
        </tr>

    </table>

</body>

</html>