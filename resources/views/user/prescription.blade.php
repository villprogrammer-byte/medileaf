@extends('user.layouts.app')

@section('title', 'Prescription')

@section('content')

    <div class="ml-user-page-head">
        <div>
            <h1><i class="bi bi-capsule-pill"></i> Prescriptions</h1>
            @if(!empty($search))
                <p>Showing results for "<strong>{{ $search }}</strong>" — <a href="{{ route('user.prescriptions') }}">clear search</a></p>
            @else
                <p>All of your prescriptions.</p>
            @endif
        </div>
    </div>

    <div class="row g-4 mt-2">

        <div class="col-xl-8">

            <div class="ml-user-card">

                <div class="ml-user-card-head">
                    <h4>
                        <i class="bi bi-capsule-pill"></i>
                        Prescription
                    </h4>
                </div>

                <div class="ml-low-stock-list">

                    @forelse($prescriptions ?? [] as $rx)

                        <div class="ml-low-stock-item">
                            <div>
                                <h6>{{ $rx->id ?? 'RX-2026-001245' }}</h6>
                                <small>{{ $rx->medicine_name ?? 'Prescription' }}</small>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success">{{ $rx->status ?? 'Active' }}</span>

                                @if(!empty($rx->download_url))
                                    <a href="{{ $rx->download_url }}" class="ml-action-btn edit d-inline-flex">
                                        <i class="bi bi-download"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                    @empty

                        <div class="text-center py-4">
                            <i class="bi bi-capsule text-success fs-3"></i>
                            <p class="mb-0 mt-2">No prescriptions found.</p>
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

@endsection
