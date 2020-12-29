@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Most Recent SooperBlog Posts</h1>
    <!-- Change to forelse for an if/else approach (eg, IF there are posts do A, if not do B) -->
    @forelse ($posts as $post)
    <div class="card my-4">
        <img src="/images/banner.jpg" class="card-img-top" alt="{{ $post->heading }}">

        <div class="card-body">
            <h2 class="card-title">
                <a href="/posts/{{ $post->id }}" class="text-dark">
                    {{ $post->heading }}
                </a>
            </h2>
            <p>Written by <em>{{ $post->author->name }}</em> on {{ $post->created_at->format('j F Y, g:ia') }}</p>
            <p>Last edited at {{ $post->updated_at->format('j F Y, g:ia') }}</p>
            <p>
                @foreach ($post->tags as $tag)
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="badge bg-dark">
                    {{ $tag->name }}
                </a>
                @endforeach
            </p>
        </div>
    </div>

    @empty
    <p>No relevant articles yet!</p>
    @endforelse
</div>
@endsection