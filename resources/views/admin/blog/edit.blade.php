@extends('admin.layouts.app')

@section('title', 'Edit Blog Post')

@section('content')

    <div class="ml-admin-page-head">
        <div>
            <h1>Edit Post</h1>
            <p>Update article content, publishing and SEO settings.</p>
        </div>

        <a href="{{ route('admin.blog.index') }}" class="ml-admin-secondary-btn">
            <i class="bi bi-arrow-left"></i>
            All Posts
        </a>
    </div>


    <form method="POST" action="{{ route('admin.blog.update', $blogPost) }}" enctype="multipart/form-data"
        class="ml-admin-blog-form">

        @csrf
        @method('PUT')

        @include('admin.blog.partials.form', [
            'post' => $blogPost
        ])

    </form>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">
@endpush