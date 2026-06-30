<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Prescription Enquiry</title>
</head>

<body style="font-family: Arial, sans-serif; color:#333;">

    <h2>New Prescription Enquiry</h2>

    <table cellpadding="8" cellspacing="0" border="1" width="100%" style="border-collapse: collapse;">

        <tr>
            <td><strong>First Name</strong></td>
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
            <td><strong>Mobile Number</strong></td>
            <td>{{ $data['mobile'] ?? '' }}</td>
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
            <td><strong>Existing Patient</strong></td>
            <td>{{ $data['patient'] ?? '' }}</td>
        </tr>

        <tr>
            <td><strong>Need Prescription For</strong></td>
            <td>
                @if(!empty($data['prescription_for']))
                    {{ implode(', ', (array) $data['prescription_for']) }}
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <td><strong>Currently Have Prescription</strong></td>
            <td>{{ $data['current_prescription'] ?? '' }}</td>
        </tr>

        <tr>
            <td><strong>Additional Notes</strong></td>
            <td>{{ $data['notes'] ?? '' }}</td>
        </tr>

        <tr>
            <td><strong>Previous Prescription</strong></td>
            <td>
                @if(!empty($data['prescription']))
                    File Attached
                @else
                    No File Uploaded
                @endif
            </td>
        </tr>

    </table>

    <br>

    <p>
        <strong>Submitted On:</strong>
        {{ now()->format('d M Y h:i A') }}
    </p>

</body>

</html>