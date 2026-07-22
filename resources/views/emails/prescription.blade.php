@extends('emails.layouts.master')

@section('title', 'New Prescription Enquiry')

@section('content')

    @php
        $fields = [
            'First Name' => $data['first_name'] ?? '',
            'Last Name' => $data['last_name'] ?? '',
            'Email' => $data['email'] ?? '',
            'Mobile Number' => $data['mobile'] ?? '',
            'Date of Birth' => $data['dob'] ?? '',
            'State / Territory' => $data['state'] ?? '',
            'Existing Patient' => $data['patient'] ?? '',
            'Need Prescription For' => !empty($data['prescription_for'])
                ? implode(', ', (array) $data['prescription_for'])
                : '-',
            'Currently Have Prescription' => $data['current_prescription'] ?? '',
            'Additional Notes' => $data['notes'] ?? 'N/A',
            'Prescription File' => !empty($file) ? 'Attached with this email' : 'No file attached',
        ];
    @endphp

    <table width="700" align="center" cellpadding="0" cellspacing="0">

        <tr>
            <td>
                <h2>New Prescription Enquiry</h2>
            </td>
        </tr>

        <tr>
            <td>

                <p>
                    A new prescription enquiry has been submitted through the
                    <strong>MediLeaf Health</strong> website.
                </p>

                <table border="1" cellpadding="10" cellspacing="0" width="100%">
                    @foreach ($fields as $label => $value)
                        <tr>
                            <td><strong>{{ $label }}</strong></td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                </table>

                <br>

                <p>
                    <strong>Submitted On:</strong>
                    {{ ($submittedAt ?? now())->format('d M Y h:i A') }}
                </p>

            </td>
        </tr>

        <tr>
            <td>
                This email was automatically generated from the MediLeaf Health website.
            </td>
        </tr>

    </table>

@endsection