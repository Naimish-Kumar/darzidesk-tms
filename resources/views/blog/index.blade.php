@extends('layouts.landing_layout')

@section('page-title')
    {{ __('Blog - Tailoring Business Tips & Software') }}
@endsection

@section('content')
    <section class="blog-section py-5">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="h1 fw-bold mb-3">Our Blog</h2>
                    <p class="text-muted">Tailoring business ko digital banaye! Tips and insights for modern tailors in India.</p>
                </div>
            </div>
            <div class="row g-4">
                @forelse ($blogs as $blog)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            @if($blog->image)
                                <img src="{{ asset(Storage::url('upload/'.$blog->image)) }}" class="card-img-top" alt="{{ $blog->title }}">
                            @endif
                            <div class="card-body">
                                <span class="text-primary small fw-bold">{{ $blog->created_at->format('M d, Y') }}</span>
                                <h3 class="h5 fw-bold mt-2"><a href="{{ route('blog.show', $blog->slug) }}" class="text-dark text-decoration-none">{{ $blog->title }}</a></h3>
                                <p class="text-muted small mt-3">{{ $blog->short_description }}</p>
                                <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-link text-primary p-0 mt-2 fw-bold text-decoration-none">Read More <i class="ti ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No blog posts found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
