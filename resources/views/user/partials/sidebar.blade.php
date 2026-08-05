@php
    $sidebarUser = auth()->user();

    $sidebarProfileFields = [
        $sidebarUser->name ?? null,
        $sidebarUser->email ?? null,
        $sidebarUser->mobile ?? null,
        $sidebarUser->dob ?? null,
    ];

    foreach ([
        'gender',
        'address_line',
        'city',
        'state',
        'postcode',
    ] as $field) {
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', $field)) {
            $sidebarProfileFields[] = $sidebarUser->{$field} ?? null;
        }
    }

    $sidebarProfileIncomplete = collect($sidebarProfileFields)
        ->contains(function ($value) {
            return blank($value);
        });
@endphp


<aside class="ml-user-sidebar">

    {{-- Logo --}}
    <div class="ml-user-logo">

        <a href="{{ route('home') }}">
            <img src="{{ asset('img/medileaf-white-logo.webp') }}" alt="MediLeaf Health">
        </a>

    </div>


    {{-- Navigation --}}
    <nav class="ml-user-nav">

        <span class="ml-user-nav-title">
            MAIN MENU
        </span>


        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>


        {{-- Current Treatment --}}
        @if($sidebarProfileIncomplete)

            <div class="ml-user-nav-locked" title="Complete your profile to access Current Treatment" aria-disabled="true">
                <i class="bi bi-heart-pulse-fill"></i>

                <span>Current Treatment</span>

                <i class="bi bi-lock-fill ml-user-nav-lock-icon"></i>
            </div>

        @else

            <a href="{{ route('user.treatment') }}" class="{{ request()->routeIs('user.treatment') ? 'active' : '' }}">
                <i class="bi bi-heart-pulse-fill"></i>
                <span>Current Treatment</span>
            </a>

        @endif


        {{-- Prescription --}}
        @if($sidebarProfileIncomplete)

            <div class="ml-user-nav-locked" title="Complete your profile to access Prescriptions" aria-disabled="true">
                <i class="bi bi-capsule-pill"></i>

                <span>Prescription</span>

                <i class="bi bi-lock-fill ml-user-nav-lock-icon"></i>
            </div>

        @else

            <a href="{{ route('user.prescriptions') }}"
                class="{{ request()->routeIs('user.prescriptions') ? 'active' : '' }}">
                <i class="bi bi-capsule-pill"></i>
                <span>Prescription</span>
            </a>

        @endif


        {{-- Appointments --}}
        @if($sidebarProfileIncomplete)

            <div class="ml-user-nav-locked" title="Complete your profile to access Appointments" aria-disabled="true">
                <i class="bi bi-calendar-check-fill"></i>

                <span>Appointments</span>

                <i class="bi bi-lock-fill ml-user-nav-lock-icon"></i>
            </div>

        @else

            <a href="{{ route('user.appointments') }}"
                class="{{ request()->routeIs('user.appointments') ? 'active' : '' }}">
                <i class="bi bi-calendar-check-fill"></i>
                <span>Appointments</span>
            </a>

        @endif


        {{-- Orders & Payments --}}
        @if($sidebarProfileIncomplete)

            <div class="ml-user-nav-locked" title="Complete your profile to access Orders and Payments"
                aria-disabled="true">
                <i class="bi bi-credit-card-fill"></i>

                <span>Orders &amp; Payments</span>

                <i class="bi bi-lock-fill ml-user-nav-lock-icon"></i>
            </div>

        @else

            <a href="{{ route('user.orders') }}" class="{{ request()->routeIs('user.orders') ? 'active' : '' }}">
                <i class="bi bi-credit-card-fill"></i>
                <span>Orders &amp; Payments</span>
            </a>

        @endif


        {{-- Profile --}}
        <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
            <i class="bi bi-person-fill"></i>

            <span>
                {{ $sidebarProfileIncomplete ? 'Complete Profile' : 'Profile' }}
            </span>

            @if($sidebarProfileIncomplete)
                <span class="ml-user-profile-warning-dot" title="Your profile is incomplete"></span>
            @endif
        </a>

    </nav>


    {{-- Bottom --}}
    <div class="ml-user-sidebar-bottom">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="ml-user-logout-btn">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>

    </div>

</aside>