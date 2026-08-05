@extends('user.layouts.app')

@section('title', 'Appointments')

@section('content')

    <div class="ml-user-page-head">
        <div>
            <h1><i class="bi bi-calendar-check-fill"></i> Appointments</h1>
            @if(!empty($search))
                <p>Showing results for "<strong>{{ $search }}</strong>" — <a href="{{ route('user.appointments') }}">clear search</a></p>
            @else
                <p>Your upcoming and past appointments.</p>
            @endif
        </div>
    </div>

    <div class="row g-4 mt-2">

        <div class="col-xl-12">

            <div class="ml-user-card">

                <div class="ml-user-card-head">
                    <h4>
                        <i class="bi bi-calendar-check-fill"></i>
                        Appointments
                    </h4>
                </div>

                @if(!empty($nextAppointment))
                    <div class="ml-low-stock-item mb-3">
                        <div>
                            <h6>Next Appointment</h6>
                            <small>
                                {{ $nextAppointment->doctor_name ?? 'Doctor' }}
                                &middot;
                                {{ $nextAppointment->type ?? 'Consultation' }}
                            </small>
                        </div>
                        <span class="badge bg-success">{{ $nextAppointment->date ?? 'N/A' }}</span>
                    </div>
                @endif

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Doctor</th>
                                <th>Reason / Notes</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($previousVisits ?? [] as $visit)

                                <tr>
                                    <td>{{ $visit->date ?? '-' }}</td>
                                    <td>{{ $visit->doctor_name ?? '-' }}</td>
                                    <td>{{ $visit->reason ?? '-' }}</td>
                                    <td><span class="badge bg-light text-dark">{{ $visit->status ?? 'Completed' }}</span></td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <i class="bi bi-calendar-x fs-3 text-muted"></i>
                                        <p class="mb-0 mt-2 text-muted">No previous visits found.</p>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
