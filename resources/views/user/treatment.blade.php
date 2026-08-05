@extends('user.layouts.app')

@section('title', 'Current Treatment')

@section('content')

    <div class="ml-user-page-head">
        <div>
            <h1><i class="bi bi-heart-pulse-fill"></i> Current Treatment</h1>
            <p>Your treatment plan and progress.</p>
        </div>
    </div>

    <div class="row g-4 mt-2">

        <div class="col-xl-8">

            <div class="ml-user-card">

                <div class="ml-user-card-head">
                    <h4>
                        <i class="bi bi-heart-pulse-fill"></i>
                        Treatment Details
                    </h4>
                </div>

                <div class="ml-low-stock-list">

                    <div class="ml-low-stock-item">
                        <div>
                            <h6>Doctor Name</h6>
                            <small>Attending physician</small>
                        </div>
                        <span class="badge bg-light text-dark">{{ $treatment->doctor_name ?? 'N/A' }}</span>
                    </div>

                    <div class="ml-low-stock-item">
                        <div>
                            <h6>Condition</h6>
                            <small>Diagnosed condition</small>
                        </div>
                        <span class="badge bg-light text-dark">{{ $treatment->condition ?? 'N/A' }}</span>
                    </div>

                    <div class="ml-low-stock-item">
                        <div>
                            <h6>Treatment Status</h6>
                            <small>Current progress</small>
                        </div>
                        <span class="badge {{ ($treatment->status ?? '') === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $treatment->status ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="ml-low-stock-item">
                        <div>
                            <h6>Start Date</h6>
                            <small>Treatment began on</small>
                        </div>
                        <span class="badge bg-light text-dark">{{ $treatment->start_date ?? 'N/A' }}</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
