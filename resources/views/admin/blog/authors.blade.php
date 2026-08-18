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

        {{-- Add Author --}}
        <div class="col-xl-4">

            <div class="ml-admin-card">

                <div class="ml-admin-card-head">
                    <h4>
                        <i class="bi bi-person-plus"></i>
                        Add Author
                    </h4>
                </div>

                <form method="POST" action="{{ route('admin.blog.authors.store') }}" enctype="multipart/form-data">

                    @csrf

                    <div class="ml-admin-blog-form-body">

                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control ml-admin-input @error('name') is-invalid @enderror"
                                placeholder="Author name" required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Role
                            </label>

                            <input type="text" name="role" value="{{ old('role') }}"
                                class="form-control ml-admin-input @error('role') is-invalid @enderror"
                                placeholder="e.g. Health Writer">

                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Bio
                            </label>

                            <textarea name="bio" rows="4"
                                class="form-control ml-admin-input ml-admin-blog-textarea @error('bio') is-invalid @enderror"
                                placeholder="Short author biography...">{{ old('bio') }}</textarea>

                            @error('bio')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Photo
                            </label>

                            <input type="text" name="image" value="{{ old('image') }}"
                                class="form-control ml-admin-input @error('image') is-invalid @enderror"
                                placeholder="img/blog/authors/name.webp">

                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <label class="ml-admin-blog-featured-check mb-4">

                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))>

                            <span>
                                Active
                            </span>

                        </label>


                        <button type="submit" class="ml-admin-add-btn">
                            <i class="bi bi-person-plus"></i>
                            Add Author
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- Existing Authors --}}
        <div class="col-xl-8">

            <div class="ml-admin-card">

                <div class="ml-admin-card-head">

                    <h4>
                        <i class="bi bi-people"></i>
                        Existing Authors
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


                                        <td>

                                            <span class="ml-admin-blog-author-role">
                                                {{ $author->role ?? '—' }}
                                            </span>

                                        </td>


                                        <td>

                                            <span class="ml-admin-blog-status {{ $author->is_active ? 'published' : 'draft' }}">
                                                {{ $author->is_active ? 'Active' : 'Inactive' }}
                                            </span>

                                        </td>


                                        <td>

                                            <div class="ml-admin-blog-actions">

                                                <a href="#" class="ml-admin-blog-action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>


                                                <form method="POST" action="{{ route('admin.blog.authors.destroy', $author) }}">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="ml-admin-blog-action-btn delete" title="Delete"
                                                        onclick="return confirm('Delete this author?')">
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
                            No authors found
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