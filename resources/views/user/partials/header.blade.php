<header class="ml-user-header">

    {{-- Mobile Menu --}}
    <button class="ml-user-menu-toggle" type="button" id="mlUserMenuToggle" aria-label="Open navigation menu">
        <i class="bi bi-list"></i>
    </button>

    {{-- Search --}}
    <form class="ml-user-search" action="{{ url()->current() }}" method="GET" role="search">

        <i class="bi bi-search"></i>

        <input type="text" name="search" value="{{ $search ?? request('search') }}"
            placeholder="Search appointments, orders, prescriptions..." aria-label="Search account records">

        @if(!empty($search ?? request('search')))
            <a href="{{ url()->current() }}" class="ml-user-search-clear" title="Clear search" aria-label="Clear search">
                <i class="bi bi-x-circle-fill"></i>
            </a>
        @endif

    </form>

    <div class="ml-user-header-actions">

        {{-- Notifications --}}
        <div class="dropdown ml-user-notification-wrap">

            <button class="ml-user-icon-btn" type="button" id="mlUserNotifBtn" data-bs-toggle="dropdown"
                aria-expanded="false" aria-label="Open notifications">
                <i class="bi bi-bell-fill"></i>

                @if(($unreadCount ?? 0) > 0)
                    <span class="ml-user-notif-count">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-end ml-user-notif-dropdown" aria-labelledby="mlUserNotifBtn">

                <div class="ml-user-notif-head">

                    <strong>Notifications</strong>

                    @if(($unreadCount ?? 0) > 0)
                        <form method="POST" action="{{ route('user.notifications.read_all') }}">
                            @csrf

                            <button type="submit" class="ml-user-notif-mark-all">
                                Mark all as read
                            </button>
                        </form>
                    @endif

                </div>

                <div class="ml-user-notif-list">

                    @forelse(($notifications ?? []) as $notif)

                        <div class="ml-user-notif-item {{ $notif->read ? '' : 'unread' }}">

                            <div class="ml-user-notif-icon">
                                <i class="bi {{ $notif->icon ?? 'bi-bell-fill' }}"></i>
                            </div>

                            <div class="ml-user-notif-body">

                                <h6>
                                    {{ $notif->title ?? 'Notification' }}
                                </h6>

                                <p>
                                    {{ $notif->message ?? '' }}
                                </p>

                                <small>
                                    {{ $notif->time ?? '' }}
                                </small>

                            </div>

                        </div>

                    @empty

                        <div class="ml-user-notif-empty">

                            <i class="bi bi-bell-slash"></i>

                            <p>No notifications yet.</p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

        {{-- Patient Profile --}}
        <div class="ml-user-profile">

            <div class="ml-user-avatar">
                <i class="bi bi-person-fill"></i>
            </div>

            <div class="ml-user-profile-info">

                <h6>
                    {{ $patient->name ?? auth()->user()->name ?? 'Patient' }}
                </h6>

                <p>Patient</p>

            </div>

        </div>

    </div>

</header>