@extends('emails.layouts.master')

@section('title', 'New Prescription Enquiry')

@section('content')

    @php
        $fields = [
            'First Name' => $data['first_name'] ?? '',
            'Last Name' => $data['last_name'] ?? '',
            'Date of Birth' => $data['dob'] ?? '',
            'State / Territory' => $data['state'] ?? '',
            'Email' => $data['email'] ?? '',
            'Mobile Number' => $data['mobile'] ?? '',
            'Additional Notes' => $data['notes'] ?? 'N/A',
            'Prescription File' => !empty($file) ? 'Attached with this email' : 'No file attached',
        ];
    @endphp

    <table class="mail-wrapper" align="center" cellpadding="0" cellspacing="0">

        <tr>
            <td class="mail-header">
                <h2>Uploaded Prescription</h2>
            </td>
        </tr>

        <tr>
            <td class="mail-body">

                <p>
                    A new prescription has been uploaded through the
                    <strong>MediLeaf Health</strong> website.
                </p>

                <table class="mail-table" cellpadding="10" cellspacing="0">
                    @foreach ($fields as $label => $value)
                        <tr>
                            <td class="label">{{ $label }}</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                </table>

                <p class="submitted-date">
                    <strong>Submitted On:</strong>
                    {{ ($submittedAt ?? now())->format('d M Y h:i A') }}
                </p>

            </td>
        </tr>

        <tr>
            <td class="mail-footer">
                This email was automatically generated from the MediLeaf Health website.
            </td>
        </tr>

    </table>

@endsection