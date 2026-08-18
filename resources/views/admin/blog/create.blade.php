@extends('admin.layouts.app')

@section('title', 'Add Blog Post')

@section('content')

    <div class="ml-admin-page-head">
        <div>
            <h1>Add New Post</h1>
            <p>Create a new SEO-ready MediLeaf article.</p>
        </div>

        <a href="{{ route('admin.blog.index') }}" class="ml-admin-secondary-btn">
            <i class="bi bi-arrow-left"></i>
            All Posts
        </a>
    </div>


    <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data" class="ml-admin-blog-form">

        @csrf

        @include('admin.blog.partials.form')

    </form>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">
@endpush