@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="card-heading">{{ $post->heading }}</h1>
    <!-- "F j, Y, g:i a" -->
    <p>Written by <em>{{ $post->author->name }}</em> on {{ $post->created_at->format('j F Y, g:ia') }}</p>
    <p>Last edited at {{ $post->updated_at->format('j F Y, g:ia') }}</p>
    <div class="card my-4">

        <div class="card-body">
            <h2>{{ $post->subheading }}</h2>
            <img src="/images/banner.jpg" class="img-fluid" alt="{{ $post->heading }}">
            <p class="my-4">{{ $post->body }}</p>
            <p>
                @foreach ($post->tags as $tag)
                <!-- <a href="/posts?tag={{ $tag->name }}">{{ $tag->name }}</a> -->
                <!-- Using a named route -->
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="badge bg-dark">
                    {{ $tag->name }}
                </a>
                @endforeach
            </p>
        </div>
    </div>
    <a href="{{ route('posts.index') }}" class="btn btn-dark">Back to Blog Posts</a>
</div>
@endsection