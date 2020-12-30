@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ Auth::user()->name }}'s Dashboard</h1>
    <div class="row justify-content-center my-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">You are logged in {{ Auth::user()->name }}!</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <a href="{{ url('/posts/create') }}" class="btn btn-dark d-block my-3">Create Post</a>

                    <a class="btn btn-secondary d-block my-3" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h2 id="my-posts">My Posts</h2>
    @forelse ($posts as $post)
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
            <p class="my-4">{{ $post->body }}</p>
            <p>
                @foreach ($post->tags as $tag)
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}" class="badge bg-dark">
                    {{ $tag->name }}
                </a>
                @endforeach
            </p>
            <a href="/posts/{{$post->id}}/edit" class="btn btn-dark px-4">Edit</a>
            <!-- <a href="" class="btn btn-danger">Delete</a> -->

            <form method="POST" action="/posts/{{ $post->id }}" class="d-inline-block">
                @csrf
                @method('DELETE')

                <div class="form-group">
                    <input type="submit" class="btn btn-danger px-4" value="Delete">
                </div>
            </form>
        </div>
    </div>

    @empty
    <p>You haven't written any posts yet {{ Auth::user()->name }}!</p>
    @endforelse
</div>
@endsection