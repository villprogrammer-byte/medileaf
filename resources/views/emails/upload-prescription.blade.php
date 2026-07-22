<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Uploaded Prescription</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; color:#333; background:#f7f7f7; padding:20px;">

    <table width="700" align="center" cellpadding="0" cellspacing="0"
        style="background:#fff;border:1px solid #e5e5e5;border-radius:8px;">

        <tr>
            <td style="background:#2f7d32;color:#fff;padding:20px;">
                <h2 style="margin:0;">New Uploaded Prescription</h2>
            </td>
        </tr>

        <tr>
            <td style="padding:25px;">

                <p>A new prescription has been uploaded through the <strong>MediLeaf Health</strong> website.</p>

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
                        <td><strong>Date of Birth</strong></td>
                        <td>{{ $data['dob'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><strong>State / Territory</strong></td>
                        <td>{{ $data['state'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{ $data['email'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><strong>Mobile Number</strong></td>
                        <td>{{ $data['mobile'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><strong>Additional Notes</strong></td>
                        <td>{{ $data['notes'] ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <td><strong>Prescription File</strong></td>
                        <td>
                            @if(!empty($file))
                                Attached with this email
                            @else
                                No file attached
                            @endif
                        </td>
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