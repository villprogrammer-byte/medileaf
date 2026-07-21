@extends('emails.layouts.master')

@section('title', 'New Prescription Enquiry')

@section('content')
    <table class="mail-wrapper" align="center" cellpadding="0" cellspacing="0">

        <tr>
            <td class="mail-header">
                <h2> Uploaded Prescription</h2>
            </td>
        </tr>

        <tr>
            <td class="mail-body">

                <p>
                    A new prescription has been uploaded through the
                    <strong>MediLeaf Health</strong> website.
                </p>

                <table class="mail-table" cellpadding="10" cellspacing="0">

                    <tr>
                        <td class="label">First Name</td>
                        <td>{{ $data['first_name'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Last Name</td>
                        <td>{{ $data['last_name'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Date of Birth</td>
                        <td>{{ $data['dob'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td class="label">State / Territory</td>
                        <td>{{ $data['state'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Email</td>
                        <td>{{ $data['email'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Mobile Number</td>
                        <td>{{ $data['mobile'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Additional Notes</td>
                        <td>{{ $data['notes'] ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Prescription File</td>
                        <td>
                            @if(!empty($file))
                                Attached with this email
                            @else
                                No file attached
                            @endif
                        </td>
                    </tr>

                </table>

                <p class="submitted-date">
                    <strong>Submitted On:</strong>
                    {{ now()->format('d M Y h:i A') }}
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