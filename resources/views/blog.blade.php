@extends('layouts.app')

@section('title', 'Blog')

@section('content')
<a href="/" class="visually-hidden-focusable skip-link">Skip to main content</a>
<div class="text-center mb-4">
    <a href="/" class="btn btn-lg glowing-btn" style="border-radius: 2rem; font-size: 1.1rem;" aria-label="Back to Home"><i class="fas fa-home me-2"></i>Back to Home</a>
</div>

<!-- Hero Section -->
<section class="hero-section py-5 position-relative" style="background: linear-gradient(120deg, #0f2027 0%, #2c5364 100%); min-height: 250px;" aria-label="Blog Hero">
    <div class="container position-relative z-2">
        <div class="row align-items-center">
            <div class="col-lg-8 animate-fade-in">
                <h1 class="display-3 fw-bold mb-3 neon-text">Blog & Insights</h1>
                <p class="lead mb-0">Explore my latest thoughts, tutorials, and stories on web development, design, and technology trends.</p>
            </div>
            <div class="col-lg-4 text-center animate-fade-in" style="animation-delay: 0.2s;">
                <img src="{{ asset('images/blog-hero.svg') }}" alt="Blog Hero" class="img-fluid floating-image" style="max-height: 120px;">
            </div>
        </div>
    </div>
    <div class="hero-bg-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index:1; opacity:0.2;"></div>
</section>

<!-- Blog Posts Grid -->
<section class="blog-section py-5" aria-label="Blog Posts">
    <div class="container">
        <div class="row g-4">
            @forelse ($posts as $post)
                <div class="col-md-6 col-lg-4 animate-fade-in">
                    <div class="card glass h-100 shadow-lg border-0 text-light position-relative transition-transform hover-scale">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-2">{{ $post->title }}</h5>
                            <p class="card-text text-secondary flex-grow-1">{{ Str::limit($post->content, 120) }}</p>
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('blog.show', ['slug' => $post->slug]) }}" class="btn btn-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="glass p-5">
                        <i class="fas fa-blog fa-3x mb-3 text-gradient"></i>
                        <h3>No Blog Posts Yet</h3>
                        <p>Check back soon for new articles and insights!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

@push('styles')
<style>
    .hero-section {
        color: #fff;
        border-radius: 0 0 2rem 2rem;
        overflow: hidden;
        position: relative;
    }
    .hero-bg-overlay {
        background: url('/images/hero-bg.svg') no-repeat center center/cover, linear-gradient(120deg, #0f2027 0%, #2c5364 100%);
    }
    .floating-image {
        animation: floatY 3s ease-in-out infinite;
    }
    @keyframes floatY {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }
    .blog-section {
        margin-top: -40px;
        z-index: 2;
        position: relative;
    }
    .card.glass {
        border-radius: 1.5rem;
        background: rgba(0, 242, 254, 0.05);
        box-shadow: 0 2px 16px rgba(0,0,0,0.08);
        transition: box-shadow 0.3s, transform 0.3s;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .card.glass:hover {
        box-shadow: 0 8px 32px rgba(0,242,254,0.12);
        transform: translateY(-6px) scale(1.02);
    }
    .card-title {
        color: var(--primary-color);
    }
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
    }
    @media (max-width: 768px) {
        .hero-section {
            text-align: center;
            min-height: 180px;
        }
        .blog-section {
            margin-top: -20px;
        }
    }
</style>
@endpush
@endsection
