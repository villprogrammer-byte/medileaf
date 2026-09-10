@extends('admin.layouts.app')

@section('title', 'Patient Details | MediLeaf Admin')

@section('content')

    @php

        /*
        |--------------------------------------------------------------------------
        | Patient Basic Information
        |--------------------------------------------------------------------------
        */

        $patientNames = $patient['name'] ?? [];
        $patientName = null;

        foreach ($patientNames as $name) {
            if (
                is_array($name)
                && strtolower((string) ($name['use'] ?? '')) === 'official'
            ) {
                $patientName = $name;
                break;
            }
        }

        if (!$patientName) {
            foreach ($patientNames as $name) {
                if (is_array($name)) {
                    $patientName = $name;
                    break;
                }
            }
        }

        if (!is_array($patientName)) {
            $patientName = [];
        }

        $firstName = trim(
            (string) ($patientName['given'][0] ?? '')
        );

        $fullName = trim(
            (string) ($patientName['text'] ?? '')
        );

        if ($fullName === '') {

            $givenNames = [];

            foreach ((array) ($patientName['given'] ?? []) as $givenName) {

                $givenName = trim((string) $givenName);

                if ($givenName !== '') {
                    $givenNames[] = $givenName;
                }
            }

            $familyName = trim(
                (string) ($patientName['family'] ?? '')
            );

            $nameParts = $givenNames;

            if ($familyName !== '') {
                $nameParts[] = $familyName;
            }

            $fullName = trim(
                implode(' ', $nameParts)
            );
        }

        if ($fullName === '') {
            $fullName = 'Unnamed Patient';
        }


        /*
        |--------------------------------------------------------------------------
        | Contact Information
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
                    MediLeaf Patients

                </a>

                <h1 class="mt-3">
                    {{ $fullName }}
                </h1>

                <p>
                    Patient ID:

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
        SUCCESS / ERROR
        ========================================================== --}}

        @if(session('success'))

            <div class="ml-halaxy-alert success">

                <i class="bi bi-check-circle-fill"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif


        @if(session('error'))

            <div class="ml-halaxy-alert error">

                <i class="bi bi-exclamation-circle-fill"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif


        @if($errors->any())

            <div class="ml-halaxy-alert error">

                <i class="bi bi-exclamation-circle-fill"></i>

                <div>

                    <strong>
                        Please check the prescription information.
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif



        {{-- =========================================================
        PATIENT PROFILE + NEXT APPOINTMENT
        ========================================================== --}}

        <div class="row g-4 mb-4">


            {{-- Patient Profile --}}
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


                        <div class="ml-halaxy-info-grid">

                            <div class="ml-halaxy-info-item">

                                <span class="ml-halaxy-info-label">
                                    Full Name
                                </span>

                                <div class="ml-halaxy-info-value">
                                    {{ $fullName }}
                                </div>

                            </div>


                            <div class="ml-halaxy-info-item">

                                <span class="ml-halaxy-info-label">
                                    Gender
                                </span>

                                <div class="ml-halaxy-info-value text-capitalize">
                                    {{ $patient['gender'] ?? '—' }}
                                </div>

                            </div>


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



            {{-- Next Appointment --}}
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

                                                                                                    <span>-</span>

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
        PRESCRIPTION DETAILS
        ========================================================== --}}

        <div class="ml-halaxy-card mb-4">

            <div class="ml-halaxy-card-head">

                <h4>
                    <i class="bi bi-capsule-pill"></i>
                    Prescription Details
                </h4>

                <span class="ml-halaxy-count-badge">
                    {{ count($prescriptions ?? []) }}
                </span>

            </div>


            <div class="ml-halaxy-card-body">


                {{-- Current Prescription --}}

                @if($latestPrescription)

                            @php

                                $prescriptionStatus =
                                    strtolower(
                                        $latestPrescription->status
                                        ?? 'active'
                                    );

                                $prescriptionStatusClass =
                                    match ($prescriptionStatus) {

                                        'active' =>
                                            'active',

                                        'completed' =>
                                            'info',

                                        'cancelled' =>
                                            'cancelled',

                                        default =>
                                            'neutral'
                                    };

                            @endphp


                            <div class="ml-halaxy-prescription-current mb-4">

                                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">

                                    <div>

                                        <span class="ml-halaxy-info-label">
                                            Current Prescription
                                        </span>

                                        <h3>
                                            {{ $latestPrescription->medicine_name }}
                                        </h3>

                                        @if($latestPrescription->strength_form)

                                            <div class="text-muted mt-1">
                                                {{ $latestPrescription->strength_form }}
                                            </div>

                                        @endif

                                    </div>


                                    <span class="ml-halaxy-status {{ $prescriptionStatusClass }}">
                                        {{ ucfirst($prescriptionStatus) }}
                                    </span>

                                </div>


                                <div class="ml-halaxy-info-grid">


                                    <div class="ml-halaxy-info-item">

                                        <span class="ml-halaxy-info-label">
                                            IHI ID
                                        </span>

                                        <div class="ml-halaxy-info-value">
                                            {{ $latestPrescription->ihi_id ?: '—' }}
                                        </div>

                                    </div>


                                    <div class="ml-halaxy-info-item">

                                        <span class="ml-halaxy-info-label">
                                            Prescription Number
                                        </span>

                                        <div class="ml-halaxy-info-value">
                                            {{ $latestPrescription->prescription_number }}
                                        </div>

                                    </div>


                                    <div class="ml-halaxy-info-item">

                                        <span class="ml-halaxy-info-label">
                                            Medicine
                                        </span>

                                        <div class="ml-halaxy-info-value">
                                            {{ $latestPrescription->medicine_name }}
                                        </div>

                                    </div>


                                    <div class="ml-halaxy-info-item">

                                        <span class="ml-halaxy-info-label">
                                            Strength / Form
                                        </span>

                                        <div class="ml-halaxy-info-value">
                                            {{ $latestPrescription->strength_form ?: '—' }}
                                        </div>

                                    </div>


                                    <div class="ml-halaxy-info-item">

                                        <span class="ml-halaxy-info-label">
                                            Quantity
                                        </span>

                                        <div class="ml-halaxy-info-value">
                                            {{ $latestPrescription->quantity ?: '—' }}
                                        </div>

                                    </div>


                                    <div class="ml-halaxy-info-item">

                                        <span class="ml-halaxy-info-label">
                                            Repeats
                                        </span>

                                        <div class="ml-halaxy-info-value">
                                            {{ $latestPrescription->repeats }}
                                        </div>

                                    </div>


                                    <div class="ml-halaxy-info-item">

                                        <span class="ml-halaxy-info-label">
                                            Interval
                                        </span>

                                        <div class="ml-halaxy-info-value">
                                            {{ $latestPrescription->interval ?: '—' }}
                                        </div>

                                    </div>


                                    <div class="ml-halaxy-info-item">

                                        <span class="ml-halaxy-info-label">
                                            Status
                                        </span>

                                        <div class="ml-halaxy-info-value">

                                            <span class="ml-halaxy-status {{ $prescriptionStatusClass }}">
                                                {{ ucfirst($prescriptionStatus) }}
                                            </span>

                                        </div>

                                    </div>

                                </div>


                                <div class="ml-halaxy-info-item mt-3">

                                    <span class="ml-halaxy-info-label">
                                        Directions
                                    </span>

                                    <div class="ml-halaxy-info-value">
                                        {{ $latestPrescription->directions ?: '—' }}
                                    </div>

                                </div>


                                <div class="mt-3 text-muted">

                                    <i class="bi bi-clock me-1"></i>

                                    Added
                                    {{ optional(
                        $latestPrescription->created_at
                    )->format('d M Y, h:i A') ?: '—' }}

                                </div>


                                {{-- Current Prescription Actions --}}
                                <div class="ml-prescription-delete-wrap justify-content-between gap-2 flex-wrap">

                                    <button type="button" class="ml-halaxy-secondary-btn" data-prescription-edit-toggle
                                        data-target="mlCurrentPrescriptionEdit" aria-expanded="false"
                                        aria-controls="mlCurrentPrescriptionEdit">

                                        <i class="bi bi-pencil-square"></i>
                                        Edit Prescription

                                    </button>


                                    <form method="POST" action="{{ route(
                        'admin.halaxy-patients.prescriptions.destroy',
                        [
                            'patientId' => $patientId,
                            'prescription' => $latestPrescription->id
                        ]
                    ) }}" class="ml-prescription-delete-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="ml-halaxy-danger-btn" data-prescription-delete
                                            data-medicine="{{ $latestPrescription->medicine_name }}">

                                            <i class="bi bi-trash3"></i>
                                            Delete Prescription

                                        </button>

                                    </form>

                                </div>


                                {{-- Current Prescription Edit Form --}}
                                <div id="mlCurrentPrescriptionEdit" class="ml-prescription-form-panel mt-4">

                                    <form method="POST" action="{{ route(
                        'admin.halaxy-patients.prescriptions.update',
                        [
                            'patientId' => $patientId,
                            'prescription' => $latestPrescription->id
                        ]
                    ) }}">

                                        @csrf
                                        @method('PUT')


                                        <div class="row g-3">

                                            <div class="col-lg-6">

                                                <label class="form-label">
                                                    IHI ID
                                                </label>

                                                <input type="text" name="ihi_id" class="form-control"
                                                    value="{{ $latestPrescription->ihi_id }}">

                                            </div>


                                            <div class="col-lg-6">

                                                <label class="form-label">
                                                    Prescription Number
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" name="prescription_number" class="form-control"
                                                    value="{{ $latestPrescription->prescription_number }}" required>

                                            </div>


                                            <div class="col-lg-6">

                                                <label class="form-label">
                                                    Medicine Name
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" name="medicine_name" class="form-control"
                                                    value="{{ $latestPrescription->medicine_name }}" required>

                                            </div>


                                            <div class="col-lg-6">

                                                <label class="form-label">
                                                    Strength / Form
                                                </label>

                                                <input type="text" name="strength_form" class="form-control"
                                                    value="{{ $latestPrescription->strength_form }}">

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">
                                                    Quantity
                                                </label>

                                                <input type="text" name="quantity" class="form-control"
                                                    value="{{ $latestPrescription->quantity }}">

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">
                                                    Repeats
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number" name="repeats" class="form-control"
                                                    value="{{ $latestPrescription->repeats }}" min="0" max="999" required>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">
                                                    Interval
                                                </label>

                                                <input type="text" name="interval" class="form-control"
                                                    value="{{ $latestPrescription->interval }}">

                                            </div>


                                            <div class="col-lg-6">

                                                <label class="form-label">
                                                    Status
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <select name="status" class="form-select" required>

                                                    <option value="active" @selected($latestPrescription->status === 'active')>
                                                        Active
                                                    </option>

                                                    <option value="completed" @selected($latestPrescription->status === 'completed')>
                                                        Completed
                                                    </option>

                                                    <option value="cancelled" @selected($latestPrescription->status === 'cancelled')>
                                                        Cancelled
                                                    </option>

                                                </select>

                                            </div>


                                            <div class="col-12">

                                                <label class="form-label">
                                                    Directions
                                                </label>

                                                <textarea name="directions" class="form-control"
                                                    rows="4">{{ $latestPrescription->directions }}</textarea>

                                            </div>


                                            <div class="col-12 pt-2">

                                                <div class="ml-prescription-form-actions">

                                                    <button type="submit" class="ml-halaxy-primary-btn">

                                                        <i class="bi bi-check-circle"></i>
                                                        Save Changes

                                                    </button>

                                                    <button type="button" class="ml-halaxy-secondary-btn" data-prescription-edit-cancel
                                                        data-target="mlCurrentPrescriptionEdit">

                                                        <i class="bi bi-x-circle"></i>
                                                        Cancel

                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                            </div>


                @else

                    <div class="ml-halaxy-empty mb-4">

                        <div class="ml-halaxy-empty-icon">
                            <i class="bi bi-capsule-pill"></i>
                        </div>

                        <h5>
                            No prescription added
                        </h5>

                        <p>
                            Add this patient's current prescription details below.
                        </p>

                    </div>

                @endif



                {{-- =================================================
                ADD NEW PRESCRIPTION
                ================================================== --}}

                @if($patientId)

                            <div class="ml-prescription-add-section border-top pt-4 mt-4">

                                <div class="ml-prescription-add-head">

                                    <div>
                                        <h5 class="mb-1">
                                            <i class="bi bi-capsule-pill me-1"></i>
                                            Add New Prescription
                                        </h5>

                                        <p class="mb-0">
                                            Add a new prescription only when required.
                                        </p>
                                    </div>

                                    <button type="button" id="mlAddPrescriptionToggle" class="ml-halaxy-primary-btn"
                                        aria-expanded="{{ $errors->any() ? 'true' : 'false' }}" aria-controls="mlAddPrescriptionPanel">

                                        <i class="bi {{ $errors->any() ? 'bi-x-lg' : 'bi-plus-circle' }}"></i>

                                        <span>
                                            {{ $errors->any() ? 'Cancel' : 'Add Prescription' }}
                                        </span>

                                    </button>

                                </div>


                                <div id="mlAddPrescriptionPanel"
                                    class="ml-prescription-form-panel {{ $errors->any() ? 'is-open' : '' }}">

                                    <form method="POST" action="{{ route(
                        'admin.halaxy-patients.prescriptions.store',
                        ['patientId' => $patientId]
                    ) }}">

                                        @csrf


                                        <div class="row g-3">

                                            <div class="col-lg-6">

                                                <label class="form-label">
                                                    IHI ID
                                                </label>

                                                <input type="text" name="ihi_id" class="form-control" value="{{ old('ihi_id') }}"
                                                    placeholder="Enter IHI ID">

                                            </div>


                                            <div class="col-lg-6">

                                                <label class="form-label">
                                                    Prescription Number
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" name="prescription_number" class="form-control"
                                                    value="{{ old('prescription_number') }}" placeholder="Enter prescription number"
                                                    required>

                                            </div>


                                            <div class="col-lg-6">

                                                <label class="form-label">
                                                    Medicine Name
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" name="medicine_name" class="form-control"
                                                    value="{{ old('medicine_name') }}" placeholder="Enter medicine name" required>

                                            </div>


                                            <div class="col-lg-6">

                                                <label class="form-label">
                                                    Strength / Form
                                                </label>

                                                <input type="text" name="strength_form" class="form-control"
                                                    value="{{ old('strength_form') }}" placeholder="Example: 18% Bud, 10G">

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">
                                                    Quantity
                                                </label>

                                                <input type="text" name="quantity" class="form-control" value="{{ old('quantity') }}"
                                                    placeholder="Example: 10">

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">
                                                    Repeats
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number" name="repeats" class="form-control" value="{{ old('repeats', 0) }}"
                                                    min="0" max="999" required>

                                            </div>


                                            <div class="col-lg-4">

                                                <label class="form-label">
                                                    Interval
                                                </label>

                                                <input type="text" name="interval" class="form-control" value="{{ old('interval') }}"
                                                    placeholder="Example: 12 days">

                                            </div>


                                            <div class="col-lg-6">

                                                <label class="form-label">
                                                    Status
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <select name="status" class="form-select" required>

                                                    <option value="active" @selected(old('status', 'active') === 'active')>
                                                        Active
                                                    </option>

                                                    <option value="completed" @selected(old('status') === 'completed')>
                                                        Completed
                                                    </option>

                                                    <option value="cancelled" @selected(old('status') === 'cancelled')>
                                                        Cancelled
                                                    </option>

                                                </select>

                                            </div>


                                            <div class="col-12">

                                                <label class="form-label">
                                                    Directions
                                                </label>

                                                <textarea name="directions" class="form-control" rows="4"
                                                    placeholder="Enter dosage and usage directions">{{ old('directions') }}</textarea>

                                            </div>


                                            <div class="col-12 pt-2">

                                                <div class="ml-prescription-form-actions">

                                                    <button type="submit" class="ml-halaxy-primary-btn">

                                                        <i class="bi bi-check-circle"></i>
                                                        Save Prescription

                                                    </button>

                                                    <button type="button" class="ml-halaxy-secondary-btn" id="mlAddPrescriptionCancel">

                                                        <i class="bi bi-x-circle"></i>
                                                        Cancel

                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                            </div>

                @endif

            </div>

        </div>



        {{-- =========================================================
        PRESCRIPTION HISTORY
        ========================================================== --}}

        @if(!empty($prescriptionHistory) && count($prescriptionHistory))

            <div class="ml-halaxy-card mb-4">

                <div class="ml-halaxy-card-head">

                    <h4>

                        <i class="bi bi-clock-history"></i>
                        Prescription History

                    </h4>

                    <span class="ml-halaxy-count-badge">
                        {{ count($prescriptionHistory) }}
                    </span>

                </div>


                <div class="ml-halaxy-card-body">

                    @foreach($prescriptionHistory as $prescription)

                            @php

                                $historyStatus =
                                    strtolower(
                                        $prescription->status
                                        ?? 'active'
                                    );

                                $historyStatusClass =
                                    match ($historyStatus) {

                                        'active' =>
                                            'active',

                                        'completed' =>
                                            'info',

                                        'cancelled' =>
                                            'cancelled',

                                        default =>
                                            'neutral'
                                    };

                            @endphp


                            <div class="border rounded-3 p-4 mb-4">

                                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">

                                    <div>

                                        <h5>
                                            {{ $prescription->medicine_name }}
                                        </h5>

                                        <div class="text-muted">

                                            Prescription:
                                            {{ $prescription->prescription_number }}

                                            <span class="mx-1">•</span>

                                            {{ optional(
                            $prescription->created_at
                        )->format('d M Y') ?: '—' }}

                                        </div>

                                    </div>


                                    <span class="ml-halaxy-status {{ $historyStatusClass }}">
                                        {{ ucfirst($historyStatus) }}
                                    </span>

                                </div>


                                <form method="POST" action="{{ route(
                            'admin.halaxy-patients.prescriptions.update',
                            [
                                'patientId' => $patientId,
                                'prescription' => $prescription->id
                            ]
                        ) }}">

                                    @csrf
                                    @method('PUT')


                                    <div class="row g-3">


                                        <div class="col-lg-6">

                                            <label class="form-label">
                                                IHI ID
                                            </label>

                                            <input type="text" name="ihi_id" class="form-control" value="{{ $prescription->ihi_id }}">

                                        </div>


                                        <div class="col-lg-6">

                                            <label class="form-label">
                                                Prescription Number
                                            </label>

                                            <input type="text" name="prescription_number" class="form-control"
                                                value="{{ $prescription->prescription_number }}" required>

                                        </div>


                                        <div class="col-lg-6">

                                            <label class="form-label">
                                                Medicine Name
                                            </label>

                                            <input type="text" name="medicine_name" class="form-control"
                                                value="{{ $prescription->medicine_name }}" required>

                                        </div>


                                        <div class="col-lg-6">

                                            <label class="form-label">
                                                Strength / Form
                                            </label>

                                            <input type="text" name="strength_form" class="form-control"
                                                value="{{ $prescription->strength_form }}">

                                        </div>


                                        <div class="col-lg-4">

                                            <label class="form-label">
                                                Quantity
                                            </label>

                                            <input type="text" name="quantity" class="form-control"
                                                value="{{ $prescription->quantity }}">

                                        </div>


                                        <div class="col-lg-4">

                                            <label class="form-label">
                                                Repeats
                                            </label>

                                            <input type="number" name="repeats" class="form-control"
                                                value="{{ $prescription->repeats }}" min="0" max="999" required>

                                        </div>


                                        <div class="col-lg-4">

                                            <label class="form-label">
                                                Interval
                                            </label>

                                            <input type="text" name="interval" class="form-control"
                                                value="{{ $prescription->interval }}">

                                        </div>


                                        <div class="col-lg-6">

                                            <label class="form-label">
                                                Status
                                            </label>

                                            <select name="status" class="form-select" required>

                                                <option value="active" @selected(
                                                    $prescription->status
                                                    === 'active'
                                                )>

                                                    Active

                                                </option>

                                                <option value="completed" @selected(
                                                    $prescription->status
                                                    === 'completed'
                                                )>

                                                    Completed

                                                </option>

                                                <option value="cancelled" @selected(
                                                    $prescription->status
                                                    === 'cancelled'
                                                )>

                                                    Cancelled

                                                </option>

                                            </select>

                                        </div>


                                        <div class="col-12">

                                            <label class="form-label">
                                                Directions
                                            </label>

                                            <textarea name="directions" class="form-control"
                                                rows="3">{{ $prescription->directions }}</textarea>

                                        </div>


                                        <div class="col-12 pt-2">

                                            <button type="submit" class="ml-halaxy-secondary-btn">

                                                <i class="bi bi-pencil-square"></i>
                                                Update Prescription

                                            </button>

                                        </div>

                                    </div>

                                </form>

                                <div class="ml-prescription-delete-wrap">

                                    <form method="POST" action="{{ route(
                            'admin.halaxy-patients.prescriptions.destroy',
                            [
                                'patientId' => $patientId,
                                'prescription' => $prescription->id
                            ]
                        ) }}" class="ml-prescription-delete-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="ml-halaxy-danger-btn" data-prescription-delete
                                            data-medicine="{{ $prescription->medicine_name }}">

                                            <i class="bi bi-trash3"></i>
                                            Delete Prescription

                                        </button>

                                    </form>

                                </div>

                            </div>

                    @endforeach

                </div>

            </div>

        @endif



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
                                <th>Date</th>
                                <th>Time</th>
                                <th>Practitioner</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Appointment ID</th>
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


                                    <td>

                                        <span class="ml-halaxy-status {{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>

                                    </td>


                                    <td>
                                        {{ $description }}
                                    </td>


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
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Balance</th>
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

                                    <td>

                                        <strong>
                                            {{ $invoiceNumber }}
                                        </strong>

                                    </td>


                                    <td>

                                        @if($invoiceDate)

                                                            {{ \Carbon\Carbon::parse(
                                                $invoiceDate
                                            )->format('d M Y') }}

                                        @else

                                            —

                                        @endif

                                    </td>


                                    <td>

                                        <span class="ml-halaxy-status {{ $invoiceStatusClass }}">
                                            {{ ucfirst($invoiceStatus) }}
                                        </span>

                                    </td>


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

@push('scripts')
    <script src="{{ asset('js/halaxy.js') }}"></script>
@endpush