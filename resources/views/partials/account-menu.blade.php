<div class="ml-account-wrap">

    @if(Auth::guard('admin')->check())

        {{-- ADMIN LOGGED IN --}}
        <div class="dropdown ml-account-desktop">

            <button class="ml-account-btn" type="button" id="mlAccountDropdown" aria-expanded="false">
                <i class="bi bi-shield-check"></i>
                <span>Admin</span>
                <i class="bi bi-chevron-down ml-account-arrow"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-end ml-account-dropdown" aria-labelledby="mlAccountDropdown">

                <a href="{{ route('admin.dashboard') }}" class="ml-account-option">
                    <span class="ml-account-icon">
                        <i class="bi bi-speedometer2"></i>
                    </span>

                    <span class="ml-account-option-text">
                        <strong>Admin Dashboard</strong>
                        <small>Manage website</small>
                    </span>
                </a>

                <div class="ml-account-divider"></div>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf

                    <button type="submit" class="ml-account-option ml-account-logout-btn">

                        <span class="ml-account-icon ml-admin-icon">
                            <i class="bi bi-box-arrow-right"></i>
                        </span>

                        <span class="ml-account-option-text">
                            <strong>Logout</strong>
                            <small>Sign out of admin</small>
                        </span>

                    </button>

                </form>

            </div>

        </div>


    @elseif(Auth::check())

        {{-- USER LOGGED IN --}}
        <div class="dropdown ml-account-desktop">

            <button class="ml-account-btn" type="button" id="mlAccountDropdown" aria-expanded="false">
                <i class="bi bi-person-check-fill"></i>
                <span>{{ Str::limit(auth()->user()->name, 14) }}</span>
                <i class="bi bi-chevron-down ml-account-arrow"></i>
            </button>


            <div class="dropdown-menu dropdown-menu-end ml-account-dropdown">

                <a href="{{ route('dashboard') }}" class="ml-account-option">

                    <span class="ml-account-icon">
                        <i class="bi bi-speedometer2"></i>
                    </span>

                    <span class="ml-account-option-text">
                        <strong>My Dashboard</strong>
                        <small>View your account</small>
                    </span>

                </a>


                <div class="ml-account-divider"></div>


                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="ml-account-option ml-account-logout-btn">

                        <span class="ml-account-icon ml-admin-icon">
                            <i class="bi bi-box-arrow-right"></i>
                        </span>

                        <span class="ml-account-option-text">
                            <strong>Logout</strong>
                            <small>Sign out of your account</small>
                        </span>

                    </button>

                </form>

            </div>

        </div>


    @else

        {{-- NOT LOGGED IN --}}

        <div class="dropdown ml-account-desktop">

            <button class="ml-account-btn" type="button" id="mlAccountDropdown" aria-expanded="false">
                <i class="bi bi-person-fill"></i>
                <span>Login</span>
                <i class="bi bi-chevron-down ml-account-arrow"></i>
            </button>


            <div class="dropdown-menu dropdown-menu-end ml-account-dropdown">

                <a href="{{ route('login') }}" class="ml-account-option">

                    <span class="ml-account-icon">
                        <i class="bi bi-person"></i>
                    </span>

                    <span class="ml-account-option-text">
                        <strong>User Login</strong>
                        <small>Login as a customer</small>
                    </span>

                </a>


                <div class="ml-account-divider"></div>


                <a href="{{ url('/admin/login') }}" class="ml-account-option">

                    <span class="ml-account-icon ml-admin-icon">
                        <i class="bi bi-shield-lock"></i>
                    </span>

                    <span class="ml-account-option-text">
                        <strong>Admin Login</strong>
                        <small>Login to admin panel</small>
                    </span>

                </a>

            </div>

        </div>

    @endif

</div>