@extends('layouts.app')

@section('title', 'Blog Post')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-light bg-dark text-light mb-4">
                <div class="card-body">
                    <h2 class="card-title text-info mb-3">{{ $post->title }}</h2>
                    <p class="card-text">{{ $post->content }}</p>
                </div>
            </div>
            <a href="{{ route('blog') }}" class="btn btn-outline-light">&larr; Back to Blog</a>
        </div>
    </div>
</div>
@endsection
