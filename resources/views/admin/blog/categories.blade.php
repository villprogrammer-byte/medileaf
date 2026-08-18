@extends('admin.layouts.app')

@section('title', 'Blog Categories')

@section('content')

    <div class="ml-admin-page-head">
        <div>
            <h1>Categories</h1>
            <p>Organise your MediLeaf health content.</p>
        </div>
    </div>


    <div class="row g-4">

        {{-- Add Category --}}
        <div class="col-xl-4">

            <div class="ml-admin-card">

                <div class="ml-admin-card-head">
                    <h4>
                        <i class="bi bi-folder-plus"></i>
                        Add Category
                    </h4>
                </div>

                <form method="POST" action="{{ route('admin.blog.categories.store') }}">

                    @csrf

                    <div class="ml-admin-blog-form-body">

                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control ml-admin-input @error('name') is-invalid @enderror"
                                placeholder="e.g. Health & Wellness" required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Slug
                            </label>

                            <input type="text" name="slug" value="{{ old('slug') }}"
                                class="form-control ml-admin-input @error('slug') is-invalid @enderror"
                                placeholder="health-wellness">

                            @error('slug')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="ml-admin-blog-help">
                                Use a short, lowercase URL slug.
                            </div>

                        </div>


                        <div class="mb-4">

                            <label class="ml-admin-label">
                                Description
                            </label>

                            <textarea name="description" rows="4"
                                class="form-control ml-admin-input ml-admin-blog-textarea @error('description') is-invalid @enderror"
                                placeholder="Brief description of this category...">{{ old('description') }}</textarea>

                            @error('description')
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
                            <i class="bi bi-plus-circle"></i>
                            Add Category
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- Existing Categories --}}
        <div class="col-xl-8">

            <div class="ml-admin-card">

                <div class="ml-admin-card-head">

                    <h4>
                        <i class="bi bi-folder2-open"></i>
                        Existing Categories
                    </h4>

                    <span class="ml-admin-blog-post-count">
                        {{ $categories->count() }}
                        {{ Str::plural('category', $categories->count()) }}
                    </span>

                </div>


                @if($categories->count())

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0 ml-admin-blog-table">

                            <thead>

                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach($categories as $category)

                                    <tr>

                                        <td>

                                            <div class="ml-admin-blog-category-name">
                                                {{ $category->name }}
                                            </div>

                                            @if($category->description)

                                                <small class="ml-admin-blog-reviewer">
                                                    {{ $category->description }}
                                                </small>

                                            @endif

                                        </td>


                                        <td>

                                            <span class="ml-admin-blog-slug">
                                                {{ $category->slug }}
                                            </span>

                                        </td>


                                        <td>

                                            <span class="ml-admin-blog-status {{ $category->is_active ? 'published' : 'draft' }}">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </span>

                                        </td>


                                        <td>

                                            <div class="ml-admin-blog-actions">

                                                <a href="{{ route('admin.blog.categories') }}#category-{{ $category->id }}"
                                                    class="ml-admin-blog-action-btn" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>


                                                <form method="POST" action="{{ route('admin.blog.categories.destroy', $category) }}"
                                                    onsubmit="return confirm('Delete this category?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="ml-admin-blog-action-btn delete" title="Delete">
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
                            <i class="bi bi-folder-x"></i>
                        </div>

                        <h4>
                            No categories found
                        </h4>

                        <p>
                            Create your first blog category to organise your content.
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