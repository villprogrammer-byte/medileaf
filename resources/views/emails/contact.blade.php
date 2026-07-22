@extends('emails.layouts.master')

@section('title', 'New Contact Enquiry')

@section('content')

    @php
        $fields = [
            'First Name' => $data['first_name'] ?? '',
            'Last Name' => $data['last_name'] ?? '',
            'Email' => $data['email'] ?? '',
            'Phone' => $data['phone'] ?? '',
            'Reason' => $data['reason'] ?? '',
        ];
    @endphp

    <table class="mail-wrapper" align="center" cellpadding="0" cellspacing="0">

        <tr>
            <td class="mail-header">
                <img src="https://medileaf.com.au/img/medileaf-white-logo.webp" alt="MediLeaf Health" width="160"
                    style="display: block; margin: 0 auto 10px auto; border: 0;">
                <h2>New Contact Enquiry</h2>
            </td>
        </tr>

        <tr>
            <td class="mail-body">

                <p>
                    A new contact enquiry has been submitted through the
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

                <p><strong>Message:</strong></p>
                <p>{{ $data['message'] ?? '' }}</p>

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