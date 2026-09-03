@extends('admin.layouts.app')

@section('title', 'Halaxy Patient | MediLeaf Admin')

@section('content')

    @php

        /*
        |--------------------------------------------------------------------------
        | Patient basic information
        |--------------------------------------------------------------------------
        */

        $firstName = $patient['name'][0]['given'][0] ?? '';
        $lastName = $patient['name'][0]['family'] ?? '';

        $fullName = trim($firstName . ' ' . $lastName);

        if (!$fullName) {
            $fullName = 'Unnamed Patient';
        }


        /*
        |--------------------------------------------------------------------------
        | Contact information
        |--------------------------------------------------------------------------
        */

        $email = null;
        $phone = null;

        foreach ($patient['telecom'] ?? [] as $telecom) {

            if (
                ($telecom['system'] ?? null) === 'email'
                && !$email
            ) {
                $email = $telecom['value'] ?? null;
            }

            if (
                ($telecom['system'] ?? null) === 'phone'
                && !$phone
            ) {
                $phone = $telecom['value'] ?? null;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Address
        |--------------------------------------------------------------------------
        */

        $address = null;

        if (!empty($patient['address'][0])) {

            $addressParts = [];

            if (!empty($patient['address'][0]['line'])) {

                $addressParts = array_merge(
                    $addressParts,
                    $patient['address'][0]['line']
                );
            }

            if (!empty($patient['address'][0]['city'])) {
                $addressParts[] = $patient['address'][0]['city'];
            }

            if (!empty($patient['address'][0]['state'])) {
                $addressParts[] = $patient['address'][0]['state'];
            }

            if (!empty($patient['address'][0]['postalCode'])) {
                $addressParts[] = $patient['address'][0]['postalCode'];
            }

            if (!empty($patient['address'][0]['country'])) {
                $addressParts[] = $patient['address'][0]['country'];
            }

            $address = implode(', ', $addressParts);
        }


        /*
        |--------------------------------------------------------------------------
        | Patient ID / Avatar
        |--------------------------------------------------------------------------
        */

        $patientId = $patient['id'] ?? null;

        $initial = strtoupper(
            substr(
                $firstName ?: $fullName,
                0,
                1
            )
        );

    @endphp


    <div class="ml-halaxy-page">


        {{-- =========================================================
        PAGE HEADER
        ========================================================== --}}
        <div class="ml-halaxy-page-head">

            <div>

                <a href="{{ route('admin.halaxy-patients.index') }}" class="ml-halaxy-back-btn">
                    <i class="bi bi-arrow-left"></i>
                    Halaxy Patients
                </a>

                <h1 class="mt-3">
                    {{ $fullName }}
                </h1>

                <p>
                    Halaxy Patient ID:

                    @if($patientId)

                        <span class="ml-halaxy-id">
                            {{ $patientId }}
                        </span>

                    @else

                        <span>—</span>

                    @endif
                </p>

            </div>


            <div class="ml-halaxy-head-actions">

                @if($patientId)

                            <a href="{{ route(
                        'admin.halaxy-patients.show',
                        ['patientId' => $patientId]
                    ) }}" class="ml-halaxy-secondary-btn">
                                <i class="bi bi-arrow-clockwise"></i>
                                Refresh
                            </a>

                @endif

            </div>

        </div>



        {{-- =========================================================
        TOP SECTION
        ========================================================== --}}
        <div class="row g-4 mb-4">


            {{-- =====================================================
            PATIENT PROFILE
            ====================================================== --}}
            <div class="col-xl-8">

                <div class="ml-halaxy-card h-100">

                    <div class="ml-halaxy-card-head">

                        <h4>
                            <i class="bi bi-person-vcard"></i>
                            Patient Profile
                        </h4>


                        @if(($patient['active'] ?? false) === true)

                            <span class="ml-halaxy-status active">
                                <i class="bi bi-check-circle-fill"></i>
                                Active
                            </span>

                        @elseif(array_key_exists('active', $patient))

                            <span class="ml-halaxy-status neutral">
                                Inactive
                            </span>

                        @endif

                    </div>


                    <div class="ml-halaxy-card-body">


                        {{-- Patient Heading --}}
                        <div class="ml-halaxy-patient-summary mb-4">

                            <div class="ml-halaxy-patient-summary-avatar">
                                {{ $initial }}
                            </div>

                            <div>

                                <h3>
                                    {{ $fullName }}
                                </h3>

                                <p class="text-capitalize mb-0">
                                    {{ $patient['gender'] ?? 'Patient' }}
                                </p>

                            </div>

                        </div>


                        {{-- Profile Information --}}
                        <div class="ml-halaxy-info-grid">


                            {{-- Full Name --}}
                            <div class="ml-halaxy-info-item">

                                <span class="ml-halaxy-info-label">
                                    Full Name
                                </span>

                                <div class="ml-halaxy-info-value">
                                    {{ $fullName }}
                                </div>

                            </div>


                            {{-- Gender --}}
                            <div class="ml-halaxy-info-item">

                                <span class="ml-halaxy-info-label">
                                    Gender
                                </span>

                                <div class="ml-halaxy-info-value text-capitalize">
                                    {{ $patient['gender'] ?? '—' }}
                                </div>

                            </div>


                            {{-- Email --}}
                            <div class="ml-halaxy-info-item">

                                <span class="ml-halaxy-info-label">
                                    Email
                                </span>

                                <div class="ml-halaxy-info-value">

                                    @if($email)

                                        <a href="mailto:{{ $email }}" class="ml-halaxy-link">
                                            {{ $email }}
                                        </a>

                                    @else

                                        —

                                    @endif

                                </div>

                            </div>


                            {{-- Phone --}}
                            <div class="ml-halaxy-info-item">

                                <span class="ml-halaxy-info-label">
                                    Phone
                                </span>

                                <div class="ml-halaxy-info-value">

                                    @if($phone)

                                        <a href="tel:{{ $phone }}" class="ml-halaxy-link">
                                            {{ $phone }}
                                        </a>

                                    @else

                                        —

                                    @endif

                                </div>

                            </div>


                            {{-- DOB --}}
                            <div class="ml-halaxy-info-item">

                                <span class="ml-halaxy-info-label">
                                    Date of Birth
                                </span>

                                <div class="ml-halaxy-info-value">

                                    @if(!empty($patient['birthDate']))

                                                                    {{ \Carbon\Carbon::parse(
                                            $patient['birthDate']
                                        )->format('d M Y') }}

                                    @else

                                        —

                                    @endif

                                </div>

                            </div>


                            {{-- Status --}}
                            <div class="ml-halaxy-info-item">

                                <span class="ml-halaxy-info-label">
                                    Patient Status
                                </span>

                                <div class="ml-halaxy-info-value">

                                    @if(($patient['active'] ?? false) === true)

                                        <span class="ml-halaxy-status active">
                                            Active
                                        </span>

                                    @elseif(array_key_exists('active', $patient))

                                        <span class="ml-halaxy-status neutral">
                                            Inactive
                                        </span>

                                    @else

                                        —

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- Address --}}
                        <div class="ml-halaxy-info-item mt-4">

                            <span class="ml-halaxy-info-label">
                                Address
                            </span>

                            <div class="ml-halaxy-info-value">
                                {{ $address ?: '—' }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =====================================================
            NEXT APPOINTMENT
            ====================================================== --}}
            <div class="col-xl-4">

                <div class="ml-halaxy-card h-100">

                    <div class="ml-halaxy-card-head">

                        <h4>
                            <i class="bi bi-calendar-check"></i>
                            Next Appointment
                        </h4>

                    </div>


                    <div class="ml-halaxy-card-body">

                        @if($nextAppointment)

                            @php

                                $nextStart =
                                    $nextAppointment['start']
                                    ?? null;

                                $nextEnd =
                                    $nextAppointment['end']
                                    ?? null;

                                $nextStatus =
                                    strtolower(
                                        $nextAppointment['status']
                                        ?? 'unknown'
                                    );

                                $nextPractitioner =
                                    $nextAppointment['practitioner_name']
                                    ?? 'Practitioner';

                                $nextStatusClass =
                                    match ($nextStatus) {

                                        'booked',
                                        'fulfilled' =>
                                        'active',

                                        'cancelled',
                                        'noshow' =>
                                        'cancelled',

                                        'arrived',
                                        'checked-in' =>
                                        'info',

                                        'pending',
                                        'proposed' =>
                                        'pending',

                                        default =>
                                        'neutral'
                                    };

                            @endphp


                            <div class="ml-halaxy-record">

                                <div class="ml-halaxy-record-left">

                                    <div class="ml-halaxy-record-icon">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>


                                    <div class="ml-halaxy-record-content">

                                        @if($nextStart)

                                                                    <div class="ml-halaxy-record-title">

                                                                        {{ \Carbon\Carbon::parse(
                                                $nextStart
                                            )->format('d M Y') }}

                                                                    </div>


                                                                    <div class="ml-halaxy-record-meta">

                                                                        {{ \Carbon\Carbon::parse(
                                                $nextStart
                                            )->format('h:i A') }}

                                                                        @if($nextEnd)

                                                                                                    <span>
                                                                                                        -
                                                                                                    </span>

                                                                                                    {{ \Carbon\Carbon::parse(
                                                                                $nextEnd
                                                                            )->format('h:i A') }}

                                                                        @endif

                                                                    </div>

                                        @else

                                            <div class="ml-halaxy-record-title">
                                                Appointment
                                            </div>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Practitioner --}}
                            <div class="ml-halaxy-info-item mt-4">

                                <span class="ml-halaxy-info-label">
                                    Practitioner
                                </span>

                                <div class="ml-halaxy-info-value">

                                    <i class="bi bi-person-badge me-1"></i>
                                    {{ $nextPractitioner }}

                                </div>

                            </div>


                            <div class="mt-4">

                                <span class="ml-halaxy-info-label">
                                    Status
                                </span>

                                <div class="mt-2">

                                    <span class="ml-halaxy-status {{ $nextStatusClass }}">
                                        {{ ucfirst($nextStatus) }}
                                    </span>

                                </div>

                            </div>


                            @if(!empty($nextAppointment['description']))

                                <div class="ml-halaxy-info-item mt-4">

                                    <span class="ml-halaxy-info-label">
                                        Description
                                    </span>

                                    <div class="ml-halaxy-info-value">
                                        {{ $nextAppointment['description'] }}
                                    </div>

                                </div>

                            @endif


                            @if(!empty($nextAppointment['id']))

                                <div class="ml-halaxy-info-item mt-4">

                                    <span class="ml-halaxy-info-label">
                                        Appointment ID
                                    </span>

                                    <div>

                                        <span class="ml-halaxy-id">
                                            {{ $nextAppointment['id'] }}
                                        </span>

                                    </div>

                                </div>

                            @endif


                        @else

                            <div class="ml-halaxy-empty">

                                <div class="ml-halaxy-empty-icon">
                                    <i class="bi bi-calendar-x"></i>
                                </div>

                                <h5>
                                    No upcoming appointment
                                </h5>

                                <p>
                                    No future appointment was found for this patient.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
        APPOINTMENTS
        ========================================================== --}}
        <div class="ml-halaxy-card mb-4">

            <div class="ml-halaxy-card-head">

                <h4>
                    <i class="bi bi-calendar3"></i>
                    Appointments
                </h4>

                <span class="ml-halaxy-count-badge">
                    {{ count($appointments ?? []) }}
                </span>

            </div>


            @if(!empty($appointments) && count($appointments))

                <div class="ml-halaxy-table-wrap">

                    <table class="ml-halaxy-table">

                        <thead>

                            <tr>

                                <th>
                                    Date
                                </th>

                                <th>
                                    Time
                                </th>

                                <th>
                                    Practitioner
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Description
                                </th>

                                <th>
                                    Appointment ID
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($appointments as $appointment)

                                @php

                                    $start =
                                        $appointment['start']
                                        ?? null;

                                    $end =
                                        $appointment['end']
                                        ?? null;

                                    $status =
                                        strtolower(
                                            $appointment['status']
                                            ?? 'unknown'
                                        );

                                    $description =
                                        $appointment['description']
                                        ?? '—';

                                    $practitionerName =
                                        $appointment['practitioner_name']
                                        ?? 'Practitioner';


                                    $statusClass =
                                        match ($status) {

                                            'booked',
                                            'fulfilled' =>
                                            'active',

                                            'cancelled',
                                            'noshow' =>
                                            'cancelled',

                                            'arrived',
                                            'checked-in' =>
                                            'info',

                                            'pending',
                                            'proposed' =>
                                            'pending',

                                            default =>
                                            'neutral'
                                        };

                                @endphp


                                <tr>

                                    {{-- Date --}}
                                    <td>

                                        @if($start)

                                                            <strong>
                                                                {{ \Carbon\Carbon::parse(
                                                $start
                                            )->format('d M Y') }}
                                                            </strong>

                                        @else

                                            —

                                        @endif

                                    </td>


                                    {{-- Time --}}
                                    <td>

                                        @if($start)

                                                            {{ \Carbon\Carbon::parse(
                                                $start
                                            )->format('h:i A') }}

                                                            @if($end)

                                                                            -
                                                                            {{ \Carbon\Carbon::parse(
                                                                    $end
                                                                )->format('h:i A') }}

                                                            @endif

                                        @else

                                            —

                                        @endif

                                    </td>


                                    {{-- Practitioner --}}
                                    <td>

                                        <div class="ml-halaxy-patient-cell">

                                            <div class="ml-halaxy-avatar">
                                                <i class="fa-solid fa-user-doctor"></i>
                                            </div>

                                            <div class="ml-halaxy-patient-info">

                                                <div class="ml-halaxy-patient-name">
                                                    {{ $practitionerName }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        <span class="ml-halaxy-status {{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>

                                    </td>


                                    {{-- Description --}}
                                    <td>
                                        {{ $description }}
                                    </td>


                                    {{-- Appointment ID --}}
                                    <td>

                                        @if(!empty($appointment['id']))

                                            <span class="ml-halaxy-id">
                                                {{ $appointment['id'] }}
                                            </span>

                                        @else

                                            —

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


            @else

                <div class="ml-halaxy-empty">

                    <div class="ml-halaxy-empty-icon">
                        <i class="bi bi-calendar3"></i>
                    </div>

                    <h5>
                        No appointments found
                    </h5>

                    <p>
                        No appointment records are currently available for this patient.
                    </p>

                </div>

            @endif

        </div>



        {{-- =========================================================
        INVOICES
        ========================================================== --}}
        <div class="ml-halaxy-card">

            <div class="ml-halaxy-card-head">

                <h4>
                    <i class="bi bi-receipt"></i>
                    Invoices
                </h4>

                <span class="ml-halaxy-count-badge">
                    {{ count($invoices ?? []) }}
                </span>

            </div>


            @if(!empty($invoices) && count($invoices))

                <div class="ml-halaxy-table-wrap">

                    <table class="ml-halaxy-table">

                        <thead>

                            <tr>

                                <th>
                                    Invoice
                                </th>

                                <th>
                                    Date
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Total
                                </th>

                                <th>
                                    Paid
                                </th>

                                <th>
                                    Balance
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($invoices as $invoice)

                                @php

                                    $invoiceNumber =
                                        $invoice['identifier'][0]['value']
                                        ?? $invoice['id']
                                        ?? '—';


                                    $invoiceDate =
                                        $invoice['date']
                                        ?? $invoice['created']
                                        ?? null;


                                    $invoiceStatus =
                                        strtolower(
                                            $invoice['status']
                                            ?? 'unknown'
                                        );


                                    $grossValue =
                                        data_get(
                                            $invoice,
                                            'totalGross.value'
                                        );

                                    $grossCurrency =
                                        data_get(
                                            $invoice,
                                            'totalGross.currency',
                                            'AUD'
                                        );


                                    $paidValue =
                                        data_get(
                                            $invoice,
                                            'totalPaid.value'
                                        );

                                    $paidCurrency =
                                        data_get(
                                            $invoice,
                                            'totalPaid.currency',
                                            $grossCurrency
                                        );


                                    $balanceValue =
                                        data_get(
                                            $invoice,
                                            'totalBalance.value'
                                        );

                                    $balanceCurrency =
                                        data_get(
                                            $invoice,
                                            'totalBalance.currency',
                                            $grossCurrency
                                        );


                                    $invoiceStatusClass =
                                        match ($invoiceStatus) {

                                            'paid',
                                            'balanced' =>
                                            'active',

                                            'issued' =>
                                            'info',

                                            'cancelled',
                                            'entered-in-error' =>
                                            'cancelled',

                                            'draft' =>
                                            'pending',

                                            default =>
                                            'neutral'
                                        };

                                @endphp


                                <tr>

                                    {{-- Invoice --}}
                                    <td>

                                        <strong>
                                            {{ $invoiceNumber }}
                                        </strong>

                                    </td>


                                    {{-- Date --}}
                                    <td>

                                        @if($invoiceDate)

                                                            {{ \Carbon\Carbon::parse(
                                                $invoiceDate
                                            )->format('d M Y') }}

                                        @else

                                            —

                                        @endif

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        <span class="ml-halaxy-status {{ $invoiceStatusClass }}">
                                            {{ ucfirst($invoiceStatus) }}
                                        </span>

                                    </td>


                                    {{-- Total --}}
                                    <td>

                                        @if($grossValue !== null)

                                                            {{ $grossCurrency }}
                                                            {{ number_format(
                                                (float) $grossValue,
                                                2
                                            ) }}

                                        @else

                                            —

                                        @endif

                                    </td>


                                    {{-- Paid --}}
                                    <td>

                                        @if($paidValue !== null)

                                                            {{ $paidCurrency }}
                                                            {{ number_format(
                                                (float) $paidValue,
                                                2
                                            ) }}

                                        @else

                                            —

                                        @endif

                                    </td>


                                    {{-- Balance --}}
                                    <td>

                                        @if($balanceValue !== null)

                                            @if((float) $balanceValue > 0)

                                                            <strong class="text-danger">

                                                                {{ $balanceCurrency }}
                                                                {{ number_format(
                                                    (float) $balanceValue,
                                                    2
                                                ) }}

                                                            </strong>

                                            @else

                                                            <strong class="text-success">

                                                                {{ $balanceCurrency }}
                                                                {{ number_format(
                                                    (float) $balanceValue,
                                                    2
                                                ) }}

                                                            </strong>

                                            @endif

                                        @else

                                            —

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


            @else

                <div class="ml-halaxy-empty">

                    <div class="ml-halaxy-empty-icon">
                        <i class="bi bi-receipt"></i>
                    </div>

                    <h5>
                        No invoices found
                    </h5>

                    <p>
                        No invoice records are currently available for this patient.
                    </p>

                </div>

            @endif

        </div>

    </div>

@endsection