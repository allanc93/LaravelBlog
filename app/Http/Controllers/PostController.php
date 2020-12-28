<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    public function index()
    {
        // Check if a certain tag is being requested
        if (request('tag')) {
            $posts = Tag::where('name', request('tag'))->firstOrFail()->posts;
        } else {
            // Can use take(x)->get(); or paginate(x);
            $posts = Post::latest()->get();
        }

        return view('posts.index', ['posts' => $posts]);
    }

    // public function show($id)
    // {
    //     $post = Post::findOrFail($id);

    //     return view('posts.show', ['post' => $post]);
    // }

    // Alternate approach to above
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    public function create()
    {
        // Pass tags as an argument
        return view('posts.create', [
            'tags' => Tag::all()
        ]);
    }

    public function store()
    {
        // request()->validate([
        //     'heading' => 'required',
        //     'subheading' => 'required',
        //     'body' => 'required'
        // ]);

        // Persist the new post
        // Creates a new Post instance (which stores token, heading, subheading and body)
        // $post = new Post();

        // $post->heading = request('heading');
        // $post->subheading = request('subheading');
        // $post->body = request('body');

        // $post->save();

        // Create post and save as above - concise approach
        // Post::create([
        //     'heading' => request('heading'),
        //     'subheading' => request('subheading'),
        //     'body' => request('body')
        // ]);

        // Most concise approach
        // $validatedAttributes = request()->validate([
        //     'heading' => 'required',
        //     'subheading' => 'required',
        //     'body' => 'required'
        // ]);

        // Post::create($validatedAttributes);

        // Most concise approach, inline version
        // Post::create(request()->validate([
        //     'heading' => 'required',
        //     'subheading' => 'required',
        //     'body' => 'required'
        // ]));

        // return redirect('/posts');

        // If using the reusable validation function
        // Post::create($this->validatePost());

        // return redirect('/posts');

        // If using the reusable validation function and passing a user_id FK
        $this->validatePost();

        // validation no longer maps to table exactly, so take specfic values
        $post = new Post(request(['heading', 'subheading', 'body']));

        $post->user_id = Auth::id();
        $post->save();

        $post->tags()->attach(request('tags'));

        // Using a named route in the redirect
        return redirect(route('posts.index'));
    }

    // Switched from using $id to Post $post
    public function edit(Post $post)
    {
        // Find post associated with id
        // $post = Post::find($id);

        return view('posts.edit',  ['post' => $post]);
    }

    // Switched from using $id to Post $post
    public function update(Post $post)
    {
        // request()->validate([
        //     'heading' => 'required',
        //     'subheading' => 'required',
        //     'body' => 'required'
        // ]);

        // // Find post associated with id
        // // $post = Post::find($id);

        // $post->heading = request('heading');
        // $post->subheading = request('subheading');
        // $post->body = request('body');

        // $post->save();

        // // Redirect to that post after it is saved
        // return redirect('/posts/' . $post->id);


        // More concise approach
        // $validatedAttributes = request()->validate([
        //     'heading' => 'required',
        //     'subheading' => 'required',
        //     'body' => 'required'
        // ]);

        // $post->update($validatedAttributes);

        // return redirect('/posts/' . $post->id);


        // More concise approach, inline version
        $post->update(request()->validate([
            'heading' => 'required',
            'subheading' => 'required',
            'body' => 'required'
        ]));

        return redirect('/posts/' . $post->id);

        // If using the reusable validation function
        $post->update($this->validatePost());

        // return redirect('/posts/' . $post->id);
    }

    // Can be used when the same validation is used more than once
    protected function validatePost()
    {
        return request()->validate([
            'heading' => 'required',
            'subheading' => 'required',
            'body' => 'required',
            'tags' => 'exists:tags,id'
        ]);
    }
}
