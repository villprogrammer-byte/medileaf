@extends('emails.layouts.master')

@section('title', 'New Contact Enquiry')

@section('content')

    <table class="mail-wrapper" cellpadding="0" cellspacing="0">

        <tr>
            <td class="mail-header">
                <h2>New Contact Enquiry</h2>
            </td>
        </tr>

        <tr>
            <td class="mail-body">

                <p>
                    A new contact enquiry has been submitted through
                    <strong>MediLeaf Health</strong> website.
                </p>

                <table class="mail-table">

                    <tr>
                        <td class="label">First Name</td>
                        <td>{{ $data['first_name'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Last Name</td>
                        <td>{{ $data['last_name'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Email</td>
                        <td>{{ $data['email'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Phone</td>
                        <td>{{ $data['phone'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Reason</td>
                        <td>{{ $data['reason'] ?? '' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Message</td>
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
            <td class="mail-footer">
                This email was automatically generated from the MediLeaf Health website.
            </td>
        </tr>

    </table>

@endsection