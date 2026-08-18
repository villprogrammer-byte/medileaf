@extends('admin.layouts.app')

@section('title', 'Blog')

@section('content')
<div class="ml-admin-blog-page">
    <div class="ml-admin-blog-header">
        <div><span class="ml-admin-eyebrow">BLOG</span><h1>Tags</h1><p>Manage reusable article topics and keywords.</p></div>
    </div>

    <div class="ml-admin-simple-grid">
        <section class="ml-admin-blog-form-card">
            <form method="POST" action="{{ route('admin.blog.tags.store') }}">
                @csrf
                <div class="ml-admin-blog-form-section">
                    <div class="ml-admin-blog-section-title"><strong>Add Tag</strong><span>Create a new article tag</span></div>
                    <label>Name</label><input name="name" required>
                    <label>Slug</label><input name="slug">
                    <label class="ml-admin-check"><input type="checkbox" name="is_active" value="1" checked><span>Active</span></label>
                    <button class="ml-admin-blog-primary" type="submit">Add Tag</button>
                </div>
            </form>
        </section>

        <section class="ml-admin-blog-table-card">
            <div class="ml-admin-blog-table-head"><strong>Existing Tags</strong></div>
            <div class="ml-admin-blog-table-wrap">
                <table class="ml-admin-blog-table">
                    <thead><tr><th>Name</th><th>Slug</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td><strong>{{ $tag->name }}</strong></td><td>{{ $tag->slug }}</td>
                            <td><span class="ml-admin-blog-status {{ $tag->is_active ? 'published' : 'draft' }}">{{ $tag->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td><div class="ml-admin-blog-actions"><a href="#"><i class="bi bi-pencil"></i></a><form method="POST" action="{{ route('admin.blog.tags.destroy', $tag) }}">@csrf @method('DELETE')<button onclick="return confirm('Delete this tag?')"><i class="bi bi-trash3"></i></button></form></div></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection

@push('styles')<link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">@endpush
