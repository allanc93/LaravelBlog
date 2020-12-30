@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Most Recent SooperBlog Posts</h1>
    <!-- Change to forelse for an if/else approach (eg, IF there are posts do A, if not do B) -->
    @forelse ($posts as $post)
    <div class="card my-4">
        @if (file_exists('storage/img/posts/post_img_' . $post->id . '.jpg'))
        <a href="/posts/{{ $post->id }}">
            <img src="/storage/img/posts/post_img_{{ $post->id }}.jpg" class="card-img-top" alt="{{ $post->heading }}">
        </a>
        @endif

        <div class="card-body">
            <h2 class="card-title">
                <a href="/posts/{{ $post->id }}" class="text-dark">
                    {{ $post->heading }}
                </a>
            </h2>
            <p>Written by <em>{{ $post->author->name }}</em> on {{ $post->created_at->format('j F Y, g:ia') }}
                @if ($post->created_at != $post->updated_at)
                <br><small>Edited: {{ $post->updated_at->format('j F Y, g:ia') }}</small>
                @endif
            </p>
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

    <div>
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection