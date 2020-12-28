@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    You are logged in {{ Auth::user()->name }}!
                    <br>
                    <!-- <a href="#my-posts" class="btn btn-dark d-block my-3">My Posts</a> -->

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



    <h1 id="my-posts">My Posts</h1>
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