@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Viewing {{ $post->heading }}</h1>
    <div class="card my-4">
        @if (file_exists('storage/img/posts/post_img_' . $post->id . '.jpg'))
        <img src="/storage/img/posts/post_img_{{ $post->id }}.jpg" class="card-img-top" alt="{{ $post->heading }}">
        @endif

        <div class="card-body">
            <h2 class="card-title">{{ $post->heading }}</h2>
            <!-- "F j, Y, g:i a" -->
            <p>Written by <em>{{ $post->author->name }}</em> on {{ $post->created_at->format('j F Y, g:ia') }}
                @if ($post->created_at != $post->updated_at)
                <br><small>Edited: {{ $post->updated_at->format('j F Y, g:ia') }}</small>
                @endif
            </p>
            <h3>{{ $post->subheading }}</h3>
            <p>{{ $post->body }}</p>
            <p>
                @foreach ($post->tags as $tag)
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