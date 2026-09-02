@extends('admin.layouts.app')

@section('title', 'Halaxy Patients | MediLeaf Admin')

@section('content')

    <div class="container-fluid px-0">

        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">

            <div>
                <h1 class="h3 mb-1">Halaxy Patients</h1>
                <p class="text-muted mb-0">
                    View existing patients connected through the Halaxy API.
                </p>
            </div>

            <div>
                <a href="{{ route('admin.halaxy-patients.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    Refresh
                </a>
            </div>

        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <form method="GET" action="{{ route('admin.halaxy-patients.index') }}">

                    <div class="row g-2 align-items-end">

                        <div class="col-lg-6 col-md-8">

                            <label class="form-label fw-semibold">
                                Search Patient
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-search"></i>
                                </span>

                                <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
                                    placeholder="Search by patient name">

                            </div>

                        </div>

                        <div class="col-lg-auto col-md-4">

                            <button type="submit" class="btn btn-success w-100">

                                <i class="bi bi-search me-1"></i>
                                Search

                            </button>

                        </div>

                        @if(!empty($search))

                            <div class="col-lg-auto">

                                <a href="{{ route('admin.halaxy-patients.index') }}" class="btn btn-light border w-100">

                                    Clear

                                </a>

                            </div>

                        @endif

                    </div>

                </form>

            </div>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white border-bottom py-3">

                <div class="d-flex align-items-center justify-content-between">

                    <div>

                        <h5 class="mb-0">
                            Patient List
                        </h5>

                    </div>

                    <span class="badge bg-light text-dark border">

                        {{ count($patients ?? []) }} shown

                    </span>

                </div>

            </div>

            <div class="card-body p-0">

                @if(!empty($patients) && count($patients))

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="ps-4">
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

                                    <th class="text-end pe-4">
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

                                        <td class="ps-4">

                                            <div class="d-flex align-items-center gap-3">

                                                <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center fw-bold"
                                                    style="width:42px;height:42px;min-width:42px;">

                                                    {{ strtoupper(substr($firstName ?: $fullName, 0, 1)) }}

                                                </div>

                                                <div>

                                                    <div class="fw-semibold text-dark">
                                                        {{ $fullName }}
                                                    </div>

                                                    @if(!empty($patient['gender']))

                                                        <small class="text-muted text-capitalize">

                                                            {{ $patient['gender'] }}

                                                        </small>

                                                    @endif

                                                </div>

                                            </div>

                                        </td>

                                        <td>

                                            @if($email)

                                                <a href="mailto:{{ $email }}" class="text-decoration-none">

                                                    {{ $email }}

                                                </a>

                                            @else

                                                <span class="text-muted">
                                                    —
                                                </span>

                                            @endif

                                        </td>

                                        <td>

                                            {{ $phone ?: '—' }}

                                        </td>

                                        <td>

                                            @if(!empty($patient['birthDate']))

                                                {{ \Carbon\Carbon::parse($patient['birthDate'])->format('d M Y') }}

                                            @else

                                                <span class="text-muted">
                                                    —
                                                </span>

                                            @endif

                                        </td>

                                        <td>

                                            <code>
                                                    {{ $patientId ?: '—' }}
                                                </code>

                                        </td>

                                        <td class="text-end pe-4">

                                            @if($patientId)

                                                <a href="{{ route('admin.halaxy-patients.show', $patientId) }}"
                                                    class="btn btn-sm btn-outline-success">

                                                    View

                                                    <i class="bi bi-arrow-right ms-1"></i>

                                                </a>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-5">

                        <div class="mb-3">

                            <i class="bi bi-people fs-1 text-muted"></i>

                        </div>

                        <h5>
                            No patients found
                        </h5>

                        <p class="text-muted mb-0">

                            No Halaxy patients matched the current request.

                        </p>

                    </div>

                @endif

            </div>

            @if(($currentPage ?? 1) > 1 || count($patients ?? []) >= 30)

                <div class="card-footer bg-white">

                    <div class="d-flex justify-content-between">

                        @if(($currentPage ?? 1) > 1)

                                    <a href="{{ route('admin.halaxy-patients.index', [
                                'page' => $currentPage - 1,
                                'search' => $search ?? null
                            ]) }}" class="btn btn-outline-secondary">

                                        <i class="bi bi-chevron-left"></i>
                                        Previous

                                    </a>

                        @else

                            <span></span>

                        @endif

                        @if(count($patients ?? []) >= 30)

                                    <a href="{{ route('admin.halaxy-patients.index', [
                                'page' => $currentPage + 1,
                                'search' => $search ?? null
                            ]) }}" class="btn btn-outline-secondary">

                                        Next
                                        <i class="bi bi-chevron-right"></i>

                                    </a>

                        @endif

                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection