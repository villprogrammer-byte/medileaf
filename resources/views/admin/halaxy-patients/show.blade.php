@extends('admin.layouts.app')

@section('title', 'Halaxy Patient | MediLeaf Admin')

@section('content')

    @php

        $firstName = $patient['name'][0]['given'][0] ?? '';
        $lastName = $patient['name'][0]['family'] ?? '';
        $fullName = trim($firstName . ' ' . $lastName);

        if (!$fullName) {
            $fullName = 'Unnamed Patient';
        }

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

    @endphp

    <div class="container-fluid px-0">

        {{-- Page Header --}}
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">

            <div>

                <div class="d-flex align-items-center gap-2 mb-2">

                    <a href="{{ route('admin.halaxy-patients.index') }}" class="text-decoration-none text-muted">
                        <i class="bi bi-arrow-left"></i>
                        Halaxy Patients
                    </a>

                </div>

                <h1 class="h3 mb-1">
                    {{ $fullName }}
                </h1>

                <p class="text-muted mb-0">

                    Halaxy Patient ID:

                    <code>
                        {{ $patient['id'] ?? '—' }}
                    </code>

                </p>

            </div>

            <div>

                <a href="{{ route('admin.halaxy-patients.show', $patient['id']) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    Refresh
                </a>

            </div>

        </div>


        {{-- Patient Overview --}}
        <div class="row g-4 mb-4">

            <div class="col-xl-8">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0">
                            Patient Profile
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Full Name
                                </div>

                                <div class="fw-semibold">
                                    {{ $fullName }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Gender
                                </div>

                                <div class="fw-semibold text-capitalize">
                                    {{ $patient['gender'] ?? '—' }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Email
                                </div>

                                <div>

                                    @if($email)

                                        <a href="mailto:{{ $email }}" class="text-decoration-none">
                                            {{ $email }}
                                        </a>

                                    @else

                                        —

                                    @endif

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Phone
                                </div>

                                <div>
                                    {{ $phone ?: '—' }}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Date of Birth
                                </div>

                                <div>

                                    @if(!empty($patient['birthDate']))

                                        {{ \Carbon\Carbon::parse($patient['birthDate'])->format('d M Y') }}

                                    @else

                                        —

                                    @endif

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Patient Status
                                </div>

                                <div>

                                    @if(($patient['active'] ?? false) === true)

                                        <span class="badge bg-success-subtle text-success">
                                            Active
                                        </span>

                                    @elseif(array_key_exists('active', $patient))

                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Inactive
                                        </span>

                                    @else

                                        —

                                    @endif

                                </div>

                            </div>

                            <div class="col-12">

                                <div class="text-muted small mb-1">
                                    Address
                                </div>

                                <div>
                                    {{ $address ?: '—' }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Next Appointment --}}
            <div class="col-xl-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-header bg-white py-3">

                        <h5 class="mb-0">
                            Next Appointment
                        </h5>

                    </div>

                    <div class="card-body">

                        @if($nextAppointment)

                            @php

                                $nextStart =
                                    $nextAppointment['start']
                                    ?? null;

                                $nextEnd =
                                    $nextAppointment['end']
                                    ?? null;

                                $nextStatus =
                                    $nextAppointment['status']
                                    ?? 'unknown';

                            @endphp

                            <div class="d-flex align-items-center gap-3 mb-4">

                                <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center"
                                    style="width:52px;height:52px;min-width:52px;">
                                    <i class="bi bi-calendar-check fs-4"></i>
                                </div>

                                <div>

                                    @if($nextStart)

                                        <div class="fw-semibold fs-5">

                                            {{ \Carbon\Carbon::parse($nextStart)->format('d M Y') }}

                                        </div>

                                        <div class="text-muted">

                                            {{ \Carbon\Carbon::parse($nextStart)->format('h:i A') }}

                                            @if($nextEnd)

                                                -
                                                {{ \Carbon\Carbon::parse($nextEnd)->format('h:i A') }}

                                            @endif

                                        </div>

                                    @endif

                                </div>

                            </div>

                            <div class="mb-3">

                                <div class="text-muted small">
                                    Status
                                </div>

                                <span class="badge bg-primary-subtle text-primary text-capitalize">
                                    {{ $nextStatus }}
                                </span>

                            </div>

                            @if(!empty($nextAppointment['description']))

                                <div>

                                    <div class="text-muted small">
                                        Description
                                    </div>

                                    <div>
                                        {{ $nextAppointment['description'] }}
                                    </div>

                                </div>

                            @endif

                        @else

                            <div class="text-center py-4">

                                <i class="bi bi-calendar-x fs-1 text-muted"></i>

                                <h6 class="mt-3">
                                    No upcoming appointment
                                </h6>

                                <p class="text-muted small mb-0">
                                    No future appointment was found for this patient.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- Appointments --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">
                        Appointments
                    </h5>

                    <span class="badge bg-light text-dark border">
                        {{ count($appointments ?? []) }}
                    </span>

                </div>

            </div>

            <div class="card-body p-0">

                @if(!empty($appointments) && count($appointments))

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="ps-4">
                                        Date
                                    </th>

                                    <th>
                                        Time
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
                                            $appointment['status']
                                            ?? '—';

                                        $description =
                                            $appointment['description']
                                            ?? '—';

                                    @endphp

                                    <tr>

                                        <td class="ps-4">

                                            @if($start)

                                                {{ \Carbon\Carbon::parse($start)->format('d M Y') }}

                                            @else

                                                —

                                            @endif

                                        </td>

                                        <td>

                                            @if($start)

                                                {{ \Carbon\Carbon::parse($start)->format('h:i A') }}

                                                @if($end)

                                                    -
                                                    {{ \Carbon\Carbon::parse($end)->format('h:i A') }}

                                                @endif

                                            @else

                                                —

                                            @endif

                                        </td>

                                        <td>

                                            @php

                                                $statusClass =
                                                    match ($status) {
                                                        'booked',
                                                        'fulfilled' =>
                                                        'bg-success-subtle text-success',

                                                        'cancelled',
                                                        'noshow' =>
                                                        'bg-danger-subtle text-danger',

                                                        'arrived',
                                                        'checked-in' =>
                                                        'bg-info-subtle text-info',

                                                        default =>
                                                        'bg-secondary-subtle text-secondary'
                                                    };

                                            @endphp

                                            <span class="badge {{ $statusClass }} text-capitalize">
                                                {{ $status }}
                                            </span>

                                        </td>

                                        <td>
                                            {{ $description }}
                                        </td>

                                        <td>

                                            <code>
                                                    {{ $appointment['id'] ?? '—' }}
                                                </code>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-5">

                        <i class="bi bi-calendar3 fs-1 text-muted"></i>

                        <h6 class="mt-3">
                            No appointments found
                        </h6>

                    </div>

                @endif

            </div>

        </div>


        {{-- Invoices --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">
                        Invoices
                    </h5>

                    <span class="badge bg-light text-dark border">
                        {{ count($invoices ?? []) }}
                    </span>

                </div>

            </div>

            <div class="card-body p-0">

                @if(!empty($invoices) && count($invoices))

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="ps-4">
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
                                            $invoice['status']
                                            ?? '—';

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

                                    @endphp

                                    <tr>

                                        <td class="ps-4 fw-semibold">

                                            {{ $invoiceNumber }}

                                        </td>

                                        <td>

                                            @if($invoiceDate)

                                                {{ \Carbon\Carbon::parse($invoiceDate)->format('d M Y') }}

                                            @else

                                                —

                                            @endif

                                        </td>

                                        <td>

                                            <span class="badge bg-primary-subtle text-primary text-capitalize">
                                                {{ $invoiceStatus }}
                                            </span>

                                        </td>

                                        <td>

                                            @if($grossValue !== null)

                                                {{ $grossCurrency }}
                                                {{ number_format((float) $grossValue, 2) }}

                                            @else

                                                —

                                            @endif

                                        </td>

                                        <td>

                                            @if($paidValue !== null)

                                                {{ $paidCurrency }}
                                                {{ number_format((float) $paidValue, 2) }}

                                            @else

                                                —

                                            @endif

                                        </td>

                                        <td>

                                            @if($balanceValue !== null)

                                                <span
                                                    class="{{ (float) $balanceValue > 0 ? 'text-danger fw-semibold' : 'text-success fw-semibold' }}">

                                                    {{ $balanceCurrency }}
                                                    {{ number_format((float) $balanceValue, 2) }}

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

                    <div class="text-center py-5">

                        <i class="bi bi-receipt fs-1 text-muted"></i>

                        <h6 class="mt-3">
                            No invoices found
                        </h6>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection