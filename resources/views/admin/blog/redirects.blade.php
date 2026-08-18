@extends('admin.layouts.app')

@section('title', 'Blog Redirects')

@section('content')

    <div class="ml-admin-page-head">
        <div>
            <h1>Blog Redirects</h1>
            <p>Keep changed article URLs safely redirected.</p>
        </div>
    </div>


    <div class="row g-4">

        {{-- Add Redirect --}}
        <div class="col-xl-4">

            <div class="ml-admin-card">

                <div class="ml-admin-card-head">
                    <h4>
                        <i class="bi bi-arrow-repeat"></i>
                        Add Redirect
                    </h4>
                </div>

                <form method="POST" action="{{ route('admin.blog.redirects.store') }}">

                    @csrf

                    <div class="ml-admin-blog-form-body">

                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Old Path <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="old_path" value="{{ old('old_path') }}"
                                class="form-control ml-admin-input @error('old_path') is-invalid @enderror"
                                placeholder="/blog/old-slug" required>

                            @error('old_path')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="mb-4">

                            <label class="ml-admin-label">
                                New Path <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="new_path" value="{{ old('new_path') }}"
                                class="form-control ml-admin-input @error('new_path') is-invalid @enderror"
                                placeholder="/blog/new-slug" required>

                            @error('new_path')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Status Code
                            </label>

                            <select name="status_code" class="form-select ml-admin-input">

                                <option value="301" @selected(old('status_code', '301') == '301')>
                                    301 Permanent
                                </option>

                                <option value="302" @selected(old('status_code') == '302')>
                                    302 Temporary
                                </option>

                            </select>

                        </div>


                        <button type="submit" class="ml-admin-add-btn">
                            <i class="bi bi-plus-circle"></i>
                            Add Redirect
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- Existing Redirects --}}
        <div class="col-xl-8">

            <div class="ml-admin-card">

                <div class="ml-admin-card-head">

                    <h4>
                        <i class="bi bi-signpost-2"></i>
                        Existing Redirects
                    </h4>

                    <span class="ml-admin-blog-post-count">
                        {{ $redirects->count() }}
                        {{ Str::plural('redirect', $redirects->count()) }}
                    </span>

                </div>


                @if($redirects->count())

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0 ml-admin-blog-table">

                            <thead>

                                <tr>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Code</th>
                                    <th class="text-end">Actions</th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach($redirects as $redirect)

                                    <tr>

                                        <td>
                                            <span class="ml-admin-blog-path">
                                                {{ $redirect->old_path }}
                                            </span>
                                        </td>


                                        <td>
                                            <span class="ml-admin-blog-path">
                                                {{ $redirect->new_path }}
                                            </span>
                                        </td>


                                        <td>

                                            <span class="ml-admin-blog-status published">
                                                {{ $redirect->status_code }}
                                            </span>

                                        </td>


                                        <td>

                                            <div class="ml-admin-blog-actions">

                                                <form method="POST" action="{{ route('admin.blog.redirects.destroy', $redirect) }}">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="ml-admin-blog-action-btn delete" title="Delete"
                                                        onclick="return confirm('Delete this redirect?')">
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
                            <i class="bi bi-signpost-2"></i>
                        </div>

                        <h4>
                            No redirects found
                        </h4>

                        <p>
                            Add a redirect when an article URL changes.
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