@extends('emails.layouts.master')

@section('title', 'New Prescription Enquiry')

@section('content')

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
            <td>
                This email was automatically generated from the MediLeaf Health website.
            </td>
        </tr>

    </table>

@endsection