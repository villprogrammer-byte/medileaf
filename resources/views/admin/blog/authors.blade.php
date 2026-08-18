@extends('admin.layouts.app')

@section('title', 'Blog Authors')

@section('content')

    <div class="ml-admin-page-head">
        <div>
            <h1>Authors & Reviewers</h1>
            <p>Manage the people credited with creating and reviewing content.</p>
        </div>
    </div>

    <div class="row g-4">

        {{-- =====================================================
        ADD AUTHOR / REVIEWER
        ====================================================== --}}
        <div class="col-xl-4">

            <div class="ml-admin-card">

                <div class="ml-admin-card-head">
                    <h4>
                        <i class="bi bi-person-plus"></i>
                        Add Author / Reviewer
                    </h4>
                </div>

                <form method="POST" action="{{ route('admin.blog.authors.store') }}" enctype="multipart/form-data">

                    @csrf

                    <div class="ml-admin-blog-form-body">

                        {{-- Name --}}
                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control ml-admin-input @error('name') is-invalid @enderror"
                                placeholder="Author or reviewer name" required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Role --}}
                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Role <span class="text-danger">*</span>
                            </label>

                            @php
                                $currentRole = old('role');
                            @endphp

                            <div class="ml-custom-select">

                                <button type="button" class="ml-custom-select-btn">
                                    <span class="ml-custom-select-value">
                                        @if($currentRole === 'author')
                                            Author
                                        @elseif($currentRole === 'reviewer')
                                            Reviewer
                                        @elseif($currentRole === 'both')
                                            Author & Reviewer
                                        @else
                                            Select role
                                        @endif
                                    </span>

                                    <i class="bi bi-chevron-down"></i>
                                </button>


                                <div class="ml-custom-select-menu">

                                    <button type="button"
                                        class="ml-custom-option {{ $currentRole === 'author' ? 'selected' : '' }}"
                                        data-value="author">
                                        Author
                                    </button>

                                    <button type="button"
                                        class="ml-custom-option {{ $currentRole === 'reviewer' ? 'selected' : '' }}"
                                        data-value="reviewer">
                                        Reviewer
                                    </button>

                                    <button type="button"
                                        class="ml-custom-option {{ $currentRole === 'both' ? 'selected' : '' }}"
                                        data-value="both">
                                        Author & Reviewer
                                    </button>

                                </div>


                                <input type="hidden" name="role" value="{{ $currentRole }}" required>

                            </div>


                            @error('role')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Bio --}}
                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Bio
                            </label>

                            <textarea name="bio" rows="4"
                                class="form-control ml-admin-input ml-admin-blog-textarea @error('bio') is-invalid @enderror"
                                placeholder="Short author or reviewer biography...">{{ old('bio') }}</textarea>

                            @error('bio')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Photo --}}
                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Photo
                            </label>

                            <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp"
                                class="form-control ml-admin-input @error('photo') is-invalid @enderror">

                            <div class="ml-admin-blog-help">
                                JPG, JPEG, PNG or WEBP. Maximum 2MB.
                            </div>

                            @error('photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Active --}}
                        <label class="ml-admin-blog-featured-check mb-4">

                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))>

                            <span>
                                Active
                            </span>

                        </label>


                        {{-- Submit --}}
                        <button type="submit" class="ml-admin-add-btn">
                            <i class="bi bi-person-plus"></i>
                            Add Author / Reviewer
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- =====================================================
        EXISTING AUTHORS
        ====================================================== --}}
        <div class="col-xl-8">

            <div class="ml-admin-card">

                <div class="ml-admin-card-head">

                    <h4>
                        <i class="bi bi-people"></i>
                        Existing Authors & Reviewers
                    </h4>

                    <span class="ml-admin-blog-post-count">
                        {{ $authors->count() }}
                        {{ Str::plural('author', $authors->count()) }}
                    </span>

                </div>


                @if($authors->count())

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0 ml-admin-blog-table">

                            <thead>

                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach($authors as $author)

                                    <tr>

                                        {{-- Name --}}
                                        <td>

                                            <div class="ml-admin-blog-author-name">
                                                {{ $author->name }}
                                            </div>

                                            @if($author->bio)

                                                <small class="ml-admin-blog-reviewer">
                                                    {{ $author->bio }}
                                                </small>

                                            @endif

                                        </td>


                                        {{-- Role --}}
                                        <td>

                                            <span class="ml-admin-blog-author-role">

                                                @if($author->role === 'author')
                                                    Author
                                                @elseif($author->role === 'reviewer')
                                                    Reviewer
                                                @elseif($author->role === 'both')
                                                    Author & Reviewer
                                                @else
                                                    —
                                                @endif

                                            </span>

                                        </td>


                                        {{-- Status --}}
                                        <td>

                                            <span class="ml-admin-blog-status {{ $author->is_active ? 'published' : 'draft' }}">
                                                {{ $author->is_active ? 'Active' : 'Inactive' }}
                                            </span>

                                        </td>


                                        {{-- Actions --}}
                                        <td>

                                            <div class="ml-admin-blog-actions">

                                                {{-- Edit --}}
                                                <a href="#" class="ml-admin-blog-action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>


                                                {{-- Delete --}}
                                                <form method="POST" action="{{ route('admin.blog.authors.destroy', $author) }}">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="ml-admin-blog-action-btn delete" title="Delete"
                                                        onclick="return confirm('Delete this author / reviewer?')">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="ml-admin-blog-empty">

                        <div class="ml-admin-blog-empty-icon">
                            <i class="bi bi-people"></i>
                        </div>

                        <h4>
                            No authors or reviewers found
                        </h4>

                        <p>
                            Create your first author or reviewer profile.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">
@endpush