@extends('admin.layouts.app')

@section('title', 'Halaxy Patients | MediLeaf Admin')

@section('content')

    <div class="ml-halaxy-page">

        {{-- =====================================================
        PAGE HEADER
        ====================================================== --}}
        <div class="ml-halaxy-page-head">

            <div>
                <h1>Halaxy Patients</h1>
                <p>
                    View and manage existing patients connected through the Halaxy API.
                </p>
            </div>

            <div class="ml-halaxy-head-actions">

                <a href="{{ route('admin.halaxy-patients.index') }}" class="ml-halaxy-secondary-btn">

                    <i class="bi bi-arrow-clockwise"></i>

                    Refresh

                </a>

            </div>

        </div>


        {{-- =====================================================
        ERROR MESSAGES
        ====================================================== --}}
        @if(session('error'))

            <div class="ml-halaxy-alert error">

                <i class="bi bi-exclamation-circle-fill"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif


        @if(isset($error))

            <div class="ml-halaxy-alert error">

                <i class="bi bi-exclamation-circle-fill"></i>

                <div>
                    {{ $error }}
                </div>

            </div>

        @endif


        {{-- =====================================================
        SEARCH
        ====================================================== --}}
        <div class="ml-halaxy-card ml-halaxy-search-card">

            <div class="ml-halaxy-card-body">

                <form method="GET" action="{{ route('admin.halaxy-patients.index') }}" class="ml-halaxy-search-form">

                    <div class="ml-halaxy-search-field">

                        <label class="ml-halaxy-search-label">
                            Search Patient
                        </label>

                        <div class="ml-halaxy-search-box">

                            <i class="bi bi-search"></i>

                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                placeholder="Search by patient name" autocomplete="off">

                        </div>

                    </div>


                    <button type="submit" class="ml-halaxy-primary-btn">

                        <i class="bi bi-search"></i>

                        Search

                    </button>


                    @if(!empty($search))

                        <a href="{{ route('admin.halaxy-patients.index') }}" class="ml-halaxy-secondary-btn">

                            <i class="bi bi-x-lg"></i>

                            Clear

                        </a>

                    @endif

                </form>

            </div>

        </div>


        {{-- =====================================================
        PATIENT LIST
        ====================================================== --}}
        <div class="ml-halaxy-card">

            <div class="ml-halaxy-card-head">

                <h4>
                    <i class="bi bi-people"></i>
                    Patient List
                </h4>

                <span class="ml-halaxy-count-badge">
                    {{ count($patients ?? []) }} shown
                </span>

            </div>


            @if(!empty($patients) && count($patients))

                <div class="ml-halaxy-table-wrap">

                    <table class="ml-halaxy-table">

                        <thead>

                            <tr>

                                <th style="padding-left: 26px;">
                                    Patient
                                </th>

                                <th>
                                    Email
                                </th>

                                <th>
                                    Phone
                                </th>

                                <th>
                                    Date of Birth
                                </th>

                                <th>
                                    Halaxy ID
                                </th>

                                <th style="text-align: right; padding-right: 26px;">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($patients as $patient)

                                            @php

                                                $firstName =
                                                    $patient['name'][0]['given'][0]
                                                    ?? '';

                                                $lastName =
                                                    $patient['name'][0]['family']
                                                    ?? '';

                                                $fullName =
                                                    trim($firstName . ' ' . $lastName);

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


                                                $patientId =
                                                    $patient['id']
                                                    ?? null;

                                            @endphp


                                            <tr>

                                                {{-- Patient --}}
                                                <td style="padding-left: 26px;">

                                                    <div class="ml-halaxy-patient-cell">

                                                        <div class="ml-halaxy-avatar">

                                                            {{ strtoupper(
                                    substr(
                                        $firstName ?: $fullName,
                                        0,
                                        1
                                    )
                                ) }}

                                                        </div>


                                                        <div class="ml-halaxy-patient-info">

                                                            <div class="ml-halaxy-patient-name">
                                                                {{ $fullName }}
                                                            </div>


                                                            @if(!empty($patient['gender']))

                                                                <span class="ml-halaxy-patient-meta">
                                                                    {{ $patient['gender'] }}
                                                                </span>

                                                            @endif

                                                        </div>

                                                    </div>

                                                </td>


                                                {{-- Email --}}
                                                <td>

                                                    @if($email)

                                                        <a href="mailto:{{ $email }}" class="ml-halaxy-link">

                                                            {{ $email }}

                                                        </a>

                                                    @else

                                                        <span class="text-muted">
                                                            —
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- Phone --}}
                                                <td>

                                                    @if($phone)

                                                        <a href="tel:{{ $phone }}" class="ml-halaxy-link">

                                                            {{ $phone }}

                                                        </a>

                                                    @else

                                                        <span class="text-muted">
                                                            —
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- DOB --}}
                                                <td>

                                                    @if(!empty($patient['birthDate']))

                                                                        {{ \Carbon\Carbon::parse(
                                                            $patient['birthDate']
                                                        )->format('d M Y') }}

                                                    @else

                                                        <span class="text-muted">
                                                            —
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- Halaxy ID --}}
                                                <td>

                                                    @if($patientId)

                                                        <span class="ml-halaxy-id">
                                                            {{ $patientId }}
                                                        </span>

                                                    @else

                                                        <span class="text-muted">
                                                            —
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- Action --}}
                                                <td style="text-align: right; padding-right: 26px;">

                                                    @if($patientId)

                                                                        <a href="{{ route(
                                                            'admin.halaxy-patients.show',
                                                            ['patientId' => $patientId]
                                                        ) }}" class="ml-halaxy-view-btn">

                                                                            View

                                                                            <i class="bi bi-arrow-right"></i>

                                                                        </a>

                                                    @endif

                                                </td>

                                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- =================================================
                PAGINATION
                ================================================== --}}
                @if(($currentPage ?? 1) > 1 || count($patients ?? []) >= 30)

                    <div class="ml-halaxy-card-footer">

                        <div class="ml-halaxy-pagination">

                            @if(($currentPage ?? 1) > 1)

                                    <a href="{{ route(
                                    'admin.halaxy-patients.index',
                                    [
                                        'page' => $currentPage - 1,
                                        'search' => $search ?? null
                                    ]
                                ) }}" class="ml-halaxy-pagination-btn">

                                        <i class="bi bi-chevron-left"></i>

                                        Previous

                                    </a>

                            @else

                                <span></span>

                            @endif


                            @if(count($patients ?? []) >= 30)

                                    <a href="{{ route(
                                    'admin.halaxy-patients.index',
                                    [
                                        'page' => $currentPage + 1,
                                        'search' => $search ?? null
                                    ]
                                ) }}" class="ml-halaxy-pagination-btn">

                                        Next

                                        <i class="bi bi-chevron-right"></i>

                                    </a>

                            @endif

                        </div>

                    </div>

                @endif


            @else

                {{-- =================================================
                EMPTY STATE
                ================================================== --}}
                <div class="ml-halaxy-empty">

                    <div class="ml-halaxy-empty-icon">
                        <i class="bi bi-people"></i>
                    </div>

                    <h5>
                        No patients found
                    </h5>

                    <p>
                        No Halaxy patients matched the current request.
                    </p>

                </div>

            @endif

        </div>

    </div>

@endsection