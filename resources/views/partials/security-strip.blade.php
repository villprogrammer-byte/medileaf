@php
    $features = $features ?? [
        ['icon' => 'bi-shield-lock', 'title' => 'Secure Admin Access', 'text' => 'Multi layer authentication keeps your admin portal protected.'],
        ['icon' => 'bi-speedometer2', 'title' => 'Smart Dashboard', 'text' => 'Manage patients, appointments and operations from one place.'],
        ['icon' => 'bi-person-workspace', 'title' => 'Staff Management', 'text' => 'Control access levels for doctors, staff and administrators.'],
        ['icon' => 'bi-clipboard2-pulse', 'title' => 'Real Time Monitoring', 'text' => 'Track appointments, prescriptions and daily activities instantly.'],
    ];
@endphp

<section class="security-strip">
    @foreach ($features as $feature)
        <div class="security-feature">
            <div class="security-feature-icon"><i class="bi {{ $feature['icon'] }}"></i></div>
            <div class="security-feature-copy">
                <strong>{{ $feature['title'] }}</strong>
                <span>{{ $feature['text'] }}</span>
            </div>
        </div>
    @endforeach
</section>