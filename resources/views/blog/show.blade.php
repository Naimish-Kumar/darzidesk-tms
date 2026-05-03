@extends('layouts.landing_layout')

@section('page-title')
    {{ $blog->title }}
@endsection

@section('content')
    <section class="blog-detail-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Post</li>
                        </ol>
                    </nav>
                    
                    @if($blog->image)
                        <img src="{{ asset(Storage::url('upload/'.$blog->image)) }}" class="img-fluid rounded-3 mb-4 w-100" alt="{{ $blog->title }}">
                    @endif

                    <span class="text-primary small fw-bold">{{ $blog->created_at->format('M d, Y') }}</span>
                    <h1 class="fw-bold my-3">{{ $blog->title }}</h1>
                    <hr class="my-4">
                    <div class="blog-content text-muted lead">
                        {!! $blog->content !!}
                    </div>
                    <div class="mt-5 p-4 bg-light rounded-3">
                        <h4 class="fw-bold mb-3">Tailoring business ko digital banaye!</h4>
                        <p>Ready to modernize your shop? Join hundreds of tailors in India using DarziDesk.</p>
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
