@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    Hey, {{ Auth::user()->name }}! {{ __('You are logged in!') }}
                    <br>
                    <a href="{{ route('posts.index') }}" class="btn btn-dark d-block my-3">My Posts</a>
                    <a href="{{ url('/posts/create') }}" class="btn btn-dark d-block my-3">Create Post</a>

                    <a class="btn btn-dark d-block my-3" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection