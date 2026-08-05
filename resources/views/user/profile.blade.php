@extends('user.layouts.app')

@section('title', 'My Profile')

@section('content')

    @php
        $user = auth()->user();

        $profileFields = [
            'Full Name' => $user->name ?? null,
            'Email Address' => $user->email ?? null,

            // Registration fields
            'Phone Number' => $user->mobile ?? null,
            'Date of Birth' => $user->dob ?? null,
        ];

        // Sirf tab check karo jab ye columns database mein maujood hon.
        foreach ([
            'gender' => 'Gender',
            'address_line' => 'Street Address',
            'city' => 'City',
            'state' => 'State',
            'postcode' => 'Postcode',
        ] as $column => $label) {

            if (\Illuminate\Support\Facades\Schema::hasColumn('users', $column)) {
                $profileFields[$label] = $user->{$column};
            }
        }

        $totalProfileFields = count($profileFields);

        $completedProfileFields = collect($profileFields)
            ->filter(fn($value) => !blank($value))
            ->count();

        $profileCompletion = $totalProfileFields > 0
            ? (int) round(($completedProfileFields / $totalProfileFields) * 100)
            : 0;

        $profileIncomplete = $profileCompletion < 100;

        $missingFields = collect($profileFields)
            ->filter(fn($value) => blank($value))
            ->keys();
    @endphp


    {{-- Page Header --}}
    <div class="ml-user-page-head">

        <div>
            <h1>My Profile</h1>

            <p>
                Manage your personal details, address and account security.
            </p>
        </div>

        <a href="{{ route('dashboard') }}" class="ml-user-add-btn">
            <i class="bi bi-grid-1x2-fill"></i>
            Back to Dashboard
        </a>

    </div>


    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-4 mb-4">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            {{ session('error') }}
        </div>
    @endif


    {{-- Profile Completion Card --}}
    <div class="ml-profile-status-card {{ $profileIncomplete ? '' : 'complete' }}">

        <div class="ml-profile-status-icon">
            <i class="bi {{ $profileIncomplete ? 'bi-person-vcard' : 'bi-patch-check-fill' }}"></i>
        </div>

        <div class="ml-profile-status-content">

            <div class="ml-profile-status-head">

                <div>
                    <h4>
                        {{ $profileIncomplete ? 'Complete Your Profile' : 'Profile Complete' }}
                    </h4>

                    <p>
                        @if($profileIncomplete)
                            Complete all required details to unlock appointments,
                            prescriptions, treatment records and orders.
                        @else
                            Your profile is complete and all dashboard sections are now available.
                        @endif
                    </p>
                </div>

                <strong>
                    {{ $profileCompletion }}%
                </strong>

            </div>

            <div class="ml-profile-status-progress" role="progressbar" aria-valuenow="{{ $profileCompletion }}"
                aria-valuemin="0" aria-valuemax="100">
                <span style="width: {{ $profileCompletion }}%;"></span>
            </div>

            @if($profileIncomplete && $missingFields->isNotEmpty())

                <div class="ml-profile-missing-fields">

                    <span class="ml-profile-missing-title">
                        Missing details:
                    </span>

                    @foreach($missingFields as $field)
                        <span class="ml-profile-missing-badge">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $field }}
                        </span>
                    @endforeach

                </div>

            @endif

        </div>

    </div>


    <div class="row g-4">

        {{-- Personal Details and Address --}}
        <div class="col-xl-7">

            <form method="POST" action="{{ route('user.profile.update') }}">

                @csrf
                @method('PUT')


                {{-- Personal Details --}}
                <div class="ml-user-card mb-4">

                    <div class="ml-user-card-head">
                        <h4>
                            <i class="bi bi-person-fill"></i>
                            Personal Details
                        </h4>
                    </div>

                    <div class="row g-3">

                        {{-- Full Name --}}
                        <div class="col-md-6">

                            <label for="name" class="ml-user-label required">
                                Full Name
                            </label>

                            <input type="text" id="name" name="name"
                                class="ml-user-input @error('name') is-invalid @enderror"
                                value="{{ old('name', $patient->name ?? '') }}" placeholder="Enter your full name" required>

                            @error('name')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- Patient ID --}}
                        <div class="col-md-6">

                            <label class="ml-user-label">
                                Medicare / Patient ID
                            </label>

                            <input type="text" class="ml-user-input" value="{{ $patient->patient_id ?? 'Not assigned' }}"
                                readonly>

                            <small class="ml-user-field-note">
                                This ID will be linked with your clinical record.
                            </small>

                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">

                            <label for="email" class="ml-user-label">
                                Email Address
                            </label>

                            <input type="email" id="email" name="email"
                                class="ml-user-input @error('email') is-invalid @enderror"
                                value="{{ old('email', $patient->email ?? '') }}" placeholder="Enter your email address">

                            @error('email')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- Phone --}}
                        <div class="col-md-6">

                            <label for="phone" class="ml-user-label required">
                                Phone Number
                            </label>

                            <input type="text" id="phone" name="phone"
                                class="ml-user-input @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $patient->phone ?? '') }}" placeholder="Enter your phone number"
                                required>

                            @error('phone')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                            @enderror

                            <small class="ml-user-field-note">
                                Use the same number while booking through Halaxy.
                            </small>

                        </div>


                        {{-- Date of Birth --}}
                        <div class="col-md-6">

                            <label for="date_of_birth" class="ml-user-label required">
                                Date of Birth
                            </label>

                            <input type="date" id="date_of_birth" name="date_of_birth"
                                class="ml-user-input @error('date_of_birth') is-invalid @enderror" value="{{ old(
        'date_of_birth',
        !empty($patient->date_of_birth)
        ? \Carbon\Carbon::parse($patient->date_of_birth)->format('Y-m-d')
        : ''
    ) }}" max="{{ now()->subDay()->format('Y-m-d') }}" required>

                            @error('date_of_birth')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- Gender --}}
                        <div class="col-md-6">

                            <label for="gender" class="ml-user-label required">
                                Gender
                            </label>

                            <select id="gender" name="gender"
                                class="ml-user-input ml-user-select @error('gender') is-invalid @enderror" required>
                                <option value="">Select gender</option>

                                <option value="male" @selected(old('gender', $patient->gender ?? '') === 'male')>
                                    Male
                                </option>

                                <option value="female" @selected(old('gender', $patient->gender ?? '') === 'female')>
                                    Female
                                </option>

                                <option value="other" @selected(old('gender', $patient->gender ?? '') === 'other')>
                                    Other
                                </option>

                                <option value="prefer_not_to_say" @selected(old('gender', $patient->gender ?? '') === 'prefer_not_to_say')>
                                    Prefer not to say
                                </option>
                            </select>

                            @error('gender')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Address --}}
                <div class="ml-user-card">

                    <div class="ml-user-card-head">
                        <h4>
                            <i class="bi bi-geo-alt-fill"></i>
                            Address
                        </h4>
                    </div>

                    <div class="row g-3">

                        {{-- Street Address --}}
                        <div class="col-12">

                            <label for="address_line" class="ml-user-label required">
                                Street Address
                            </label>

                            <input type="text" id="address_line" name="address_line"
                                class="ml-user-input @error('address_line') is-invalid @enderror"
                                value="{{ old('address_line', $patient->address_line ?? '') }}"
                                placeholder="Enter your street address" required>

                            @error('address_line')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- City --}}
                        <div class="col-md-4">

                            <label for="city" class="ml-user-label required">
                                City
                            </label>

                            <input type="text" id="city" name="city"
                                class="ml-user-input @error('city') is-invalid @enderror"
                                value="{{ old('city', $patient->city ?? '') }}" placeholder="City" required>

                            @error('city')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- State --}}
                        <div class="col-md-4">

                            <label for="state" class="ml-user-label required">
                                State
                            </label>

                            <select id="state" name="state"
                                class="ml-user-input ml-user-select @error('state') is-invalid @enderror" required>
                                <option value="">Select state</option>

                                @php
                                    $states = [
                                        'ACT' => 'Australian Capital Territory',
                                        'NSW' => 'New South Wales',
                                        'NT' => 'Northern Territory',
                                        'QLD' => 'Queensland',
                                        'SA' => 'South Australia',
                                        'TAS' => 'Tasmania',
                                        'VIC' => 'Victoria',
                                        'WA' => 'Western Australia',
                                    ];
                                @endphp

                                @foreach($states as $code => $stateName)
                                    <option value="{{ $code }}" @selected(old('state', $patient->state ?? '') === $code)>
                                        {{ $stateName }}
                                    </option>
                                @endforeach

                            </select>

                            @error('state')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- Postcode --}}
                        <div class="col-md-4">

                            <label for="postcode" class="ml-user-label required">
                                Postcode
                            </label>

                            <input type="text" id="postcode" name="postcode"
                                class="ml-user-input @error('postcode') is-invalid @enderror"
                                value="{{ old('postcode', $patient->postcode ?? '') }}" placeholder="Postcode"
                                inputmode="numeric" maxlength="4" pattern="[0-9]{4}" required>

                            @error('postcode')
                                <small class="text-danger d-block mt-1">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- Save --}}
                        <div class="col-12 mt-3">

                            <button type="submit" class="ml-product-publish-btn px-4">

                                <i class="bi bi-check-circle me-1"></i>

                                {{ $profileIncomplete
        ? 'Save and Complete Profile'
        : 'Save Profile Changes'
                                        }}

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>


        {{-- Right Column --}}
        <div class="col-xl-5">

            {{-- Profile Security Note --}}
            <div class="ml-user-card mb-4">

                <div class="ml-user-card-head">
                    <h4>
                        <i class="bi bi-shield-check"></i>
                        Profile Security
                    </h4>
                </div>

                <div class="ml-profile-security-list">

                    <div class="ml-profile-security-item">
                        <i class="bi bi-envelope-check-fill"></i>

                        <div>
                            <strong>Email Verification</strong>
                            <span>
                                {{ !empty($user->email_verified_at)
        ? 'Your email address is verified.'
        : 'Your email address is not verified.'
                                        }}
                            </span>
                        </div>
                    </div>

                    <div class="ml-profile-security-item">
                        <i class="bi bi-phone-fill"></i>

                        <div>
                            <strong>Mobile Number</strong>
                            <span>
                                Used to safely link your Halaxy patient record.
                            </span>
                        </div>
                    </div>

                    <div class="ml-profile-security-item">
                        <i class="bi bi-lock-fill"></i>

                        <div>
                            <strong>Protected Information</strong>
                            <span>
                                Your personal and clinical information remains securely protected.
                            </span>
                        </div>
                    </div>

                </div>

            </div>


            {{-- Change Password --}}
            <div class="ml-user-card">

                <div class="ml-user-card-head">
                    <h4>
                        <i class="bi bi-shield-lock-fill"></i>
                        Change Password
                    </h4>
                </div>

                <form method="POST" action="{{ route('user.profile.password') }}">

                    @csrf

                    <div class="mb-3">

                        <label for="current_password" class="ml-user-label">
                            Current Password
                        </label>

                        <input type="password" id="current_password" name="current_password"
                            class="ml-user-input @error('current_password') is-invalid @enderror"
                            autocomplete="current-password">

                        @error('current_password')
                            <small class="text-danger d-block mt-1">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    <div class="mb-3">

                        <label for="password" class="ml-user-label">
                            New Password
                        </label>

                        <input type="password" id="password" name="password"
                            class="ml-user-input @error('password') is-invalid @enderror" autocomplete="new-password">

                        @error('password')
                            <small class="text-danger d-block mt-1">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    <div class="mb-3">

                        <label for="password_confirmation" class="ml-user-label">
                            Confirm New Password
                        </label>

                        <input type="password" id="password_confirmation" name="password_confirmation" class="ml-user-input"
                            autocomplete="new-password">

                    </div>

                    <button type="submit" class="ml-product-publish-btn w-100 mt-2">
                        <i class="bi bi-shield-check me-1"></i>
                        Update Password
                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection