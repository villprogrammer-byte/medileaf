@extends('user.layouts.app')

@section('title', 'My Dashboard')

@section('content')

    @php
        $user = auth()->user();

        $profileFields = [
            'name' => $user->name ?? null,
            'email' => $user->email ?? null,
            'mobile' => $user->mobile ?? null,
            'dob' => $user->dob ?? null,
        ];

        foreach (['gender', 'address_line', 'city', 'state', 'postcode'] as $field) {
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', $field)) {
                $profileFields[$field] = $user->{$field} ?? null;
            }
        }

        $totalProfileFields = count($profileFields);

        $completedProfileFields = collect($profileFields)
            ->filter(function ($value) {
                return !blank($value);
            })
            ->count();

        $profileCompletion = $totalProfileFields > 0
            ? (int) round(($completedProfileFields / $totalProfileFields) * 100)
            : 0;

        $profileIncomplete = $profileCompletion < 100;

        $treatmentStatus = strtolower($treatment->status ?? '');
    @endphp


    {{-- Page Header --}}
    <div class="ml-user-page-head">

        <div>
            <h1>
                Hello, {{ $patient->name ?? $user->name ?? 'Patient' }} 👋
            </h1>

            <p>
                Welcome back! Here is your account overview.
            </p>
        </div>

        <a href="{{ route('user.profile') }}" class="ml-user-add-btn">
            <i class="bi bi-person-gear"></i>

            {{ $profileIncomplete ? 'Complete Profile' : 'Edit Profile' }}
        </a>

    </div>


    {{-- Profile Completion Banner --}}
    @if($profileIncomplete)

        <div class="ml-profile-complete-card">

            <div class="ml-profile-complete-icon">
                <i class="bi bi-person-vcard"></i>
            </div>

            <div class="ml-profile-complete-content">

                <div class="ml-profile-complete-heading">

                    <div>
                        <h4>Complete Your Profile</h4>

                        <p>
                            Complete your personal details to unlock appointments,
                            prescriptions, treatment records and orders.
                        </p>
                    </div>

                    <strong class="ml-profile-percentage">
                        {{ $profileCompletion }}%
                    </strong>

                </div>

                <div class="ml-profile-progress" role="progressbar" aria-label="Profile completion"
                    aria-valuenow="{{ $profileCompletion }}" aria-valuemin="0" aria-valuemax="100">
                    <span style="width: {{ $profileCompletion }}%;"></span>
                </div>

                <small class="ml-profile-progress-copy">
                    {{ $completedProfileFields }} of {{ $totalProfileFields }}
                    required details completed
                </small>

            </div>

            <a href="{{ route('user.profile') }}" class="ml-profile-complete-btn">
                Fill Your Details
                <i class="bi bi-arrow-right"></i>
            </a>

        </div>

    @endif


    {{-- Top Summary Cards --}}
    <div class="ml-user-stats-grid">

        {{-- Patient ID --}}
        <div class="ml-user-stat-card">

            <div class="ml-user-stat-icon green">
                <i class="bi bi-person-vcard-fill"></i>
            </div>

            <div>
                <p>Patient ID</p>

                <h3>
                    {{ $patient->patient_id ?? 'N/A' }}
                </h3>
            </div>

        </div>


        {{-- Last Login --}}
        <div class="ml-user-stat-card">

            <div class="ml-user-stat-icon lime">
                <i class="bi bi-clock-history"></i>
            </div>

            <div>
                <p>Last Login</p>

                <h3>
                    @if(!empty($patient->last_login))
                        {{ \Carbon\Carbon::parse($patient->last_login)->format('d M Y, h:i A') }}
                    @else
                        —
                    @endif
                </h3>
            </div>

        </div>


        {{-- Treatment Status --}}
        @if($profileIncomplete)

            <div class="ml-user-stat-card ml-user-stat-card-locked">

                <div class="ml-user-stat-icon locked">
                    <i class="bi bi-lock-fill"></i>
                </div>

                <div>
                    <p>Treatment Status</p>
                    <h3>Profile Required</h3>
                </div>

                <span class="ml-stat-lock-icon">
                    <i class="bi bi-lock-fill"></i>
                </span>

            </div>

        @else

            <a href="{{ route('user.treatment') }}" class="ml-user-stat-card ml-user-stat-link">

                <div class="ml-user-stat-icon {{ $treatmentStatus === 'active' ? 'red' : 'blue' }}">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>

                <div>
                    <p>Treatment Status</p>
                    <h3>{{ $treatment->status ?? 'N/A' }}</h3>
                </div>

            </a>

        @endif


        {{-- Next Appointment --}}
        @if($profileIncomplete)

            <div class="ml-user-stat-card ml-user-stat-card-locked">

                <div class="ml-user-stat-icon locked">
                    <i class="bi bi-lock-fill"></i>
                </div>

                <div>
                    <p>Next Appointment</p>
                    <h3>Profile Required</h3>
                </div>

                <span class="ml-stat-lock-icon">
                    <i class="bi bi-lock-fill"></i>
                </span>

            </div>

        @else

            <a href="{{ route('user.appointments') }}" class="ml-user-stat-card ml-user-stat-link">

                <div class="ml-user-stat-icon blue">
                    <i class="bi bi-calendar-event-fill"></i>
                </div>

                <div>
                    <p>Next Appointment</p>

                    <h3>
                        @if(!empty($nextAppointment->date))
                            {{ \Carbon\Carbon::parse($nextAppointment->date)->format('d M Y') }}
                        @else
                            Not Scheduled
                        @endif
                    </h3>
                </div>

            </a>

        @endif

    </div>


    {{-- Dashboard Quick Links --}}
    <div class="row g-4 mt-2">

        {{-- Current Treatment --}}
        <div class="col-md-6 col-xl-3">

            @if($profileIncomplete)

                <div class="ml-user-card ml-user-dashboard-link ml-user-card-locked">

                    <div class="ml-card-lock-badge">
                        <i class="bi bi-lock-fill"></i>
                        Locked
                    </div>

                    <h4 class="mb-1">
                        <i class="bi bi-heart-pulse-fill"></i>
                        Current Treatment
                    </h4>

                    <p class="mb-0">
                        Complete your profile to access treatment details.
                    </p>

                </div>

            @else

                <a href="{{ route('user.treatment') }}" class="ml-user-card ml-user-dashboard-link d-block">

                    <h4 class="mb-1">
                        <i class="bi bi-heart-pulse-fill"></i>
                        Current Treatment
                    </h4>

                    <p class="mb-0 text-muted">
                        View your treatment details
                    </p>

                </a>

            @endif

        </div>


        {{-- Prescriptions --}}
        <div class="col-md-6 col-xl-3">

            @if($profileIncomplete)

                <div class="ml-user-card ml-user-dashboard-link ml-user-card-locked">

                    <div class="ml-card-lock-badge">
                        <i class="bi bi-lock-fill"></i>
                        Locked
                    </div>

                    <h4 class="mb-1">
                        <i class="bi bi-capsule-pill"></i>
                        Prescriptions
                    </h4>

                    <p class="mb-0">
                        Complete your profile to access prescriptions.
                    </p>

                </div>

            @else

                <a href="{{ route('user.prescriptions') }}" class="ml-user-card ml-user-dashboard-link d-block">

                    <h4 class="mb-1">
                        <i class="bi bi-capsule-pill"></i>
                        Prescriptions
                    </h4>

                    <p class="mb-0 text-muted">
                        View your prescriptions
                    </p>

                </a>

            @endif

        </div>


        {{-- Appointments --}}
        <div class="col-md-6 col-xl-3">

            @if($profileIncomplete)

                <div class="ml-user-card ml-user-dashboard-link ml-user-card-locked">

                    <div class="ml-card-lock-badge">
                        <i class="bi bi-lock-fill"></i>
                        Locked
                    </div>

                    <h4 class="mb-1">
                        <i class="bi bi-calendar-check-fill"></i>
                        Appointments
                    </h4>

                    <p class="mb-0">
                        Complete your profile to access appointments.
                    </p>

                </div>

            @else

                <a href="{{ route('user.appointments') }}" class="ml-user-card ml-user-dashboard-link d-block">

                    <h4 class="mb-1">
                        <i class="bi bi-calendar-check-fill"></i>
                        Appointments
                    </h4>

                    <p class="mb-0 text-muted">
                        View your appointments
                    </p>

                </a>

            @endif

        </div>


        {{-- Orders --}}
        <div class="col-md-6 col-xl-3">

            @if($profileIncomplete)

                <div class="ml-user-card ml-user-dashboard-link ml-user-card-locked">

                    <div class="ml-card-lock-badge">
                        <i class="bi bi-lock-fill"></i>
                        Locked
                    </div>

                    <h4 class="mb-1">
                        <i class="bi bi-credit-card-fill"></i>
                        Orders &amp; Payments
                    </h4>

                    <p class="mb-0">
                        Complete your profile to access orders and payments.
                    </p>

                </div>

            @else

                <a href="{{ route('user.orders') }}" class="ml-user-card ml-user-dashboard-link d-block">

                    <h4 class="mb-1">
                        <i class="bi bi-credit-card-fill"></i>
                        Orders &amp; Payments
                    </h4>

                    <p class="mb-0 text-muted">
                        View your orders and payment history
                    </p>

                </a>

            @endif

        </div>

    </div>

@endsection