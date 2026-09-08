@extends('admin.layouts.app')

@section('title', 'Edit Blog Post')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger mb-4">

            <strong>
                Blog post update nahi hua:
            </strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>

        </div>
    @endif


    <div class="ml-admin-page-head">

        <div>
            <h1>
                Edit Post
            </h1>

            <p>
                Update article content, publishing, featured image and SEO settings.
            </p>
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

    {{-- Blog Admin Styles --}}
    <link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">

    {{-- Product-style Featured Image / Gallery UI --}}
    <link rel="stylesheet" href="{{ asset('css/product-variants.css') }}">

@endpush