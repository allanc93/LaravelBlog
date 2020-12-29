<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    // Show all posts
    public function index()
    {
        // Check if a tag is within the request
        if (request('tag')) {
            $posts = Tag::where('name', request('tag'))->firstOrFail()->posts;
        } else {
            // Could use take(x)->get(); or paginate(x);
            $posts = Post::latest()->get();
        }

        // Return the posts>index view (blade file)
        return view('posts.index', ['posts' => $posts]);
    }

    // Show a single post (based on an id)
    public function show(Post $post)
    {
        // Return the posts>show view (blade file)
        return view('posts.show', ['post' => $post]);
    }

    // When a new post is to be created, return the create form
    public function create()
    {
        // Return the posts>create view (blade file)
        return view('posts.create', [
            'tags' => Tag::all() // Pass tags as an argument
        ]);
    }

    // Validate user input from create form and persist to database
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

        // Return a redirect to the home view (blade file) - uses a named route 'home'
        return redirect(route('home'));
    }

    // When a post is to be edited, return the edit form
    public function edit(Post $post)
    {
        return view('posts.edit',  ['post' => $post]);
    }

    // Validate user input from update form and persist to database
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

        // return redirect('/posts/' . $post->id);
        return redirect(route('home'));

        // If using the reusable validation function
        $post->update($this->validatePost());

        // return redirect('/posts/' . $post->id);
    }

    // Deletes a specific post based on an id
    public function destroy(Post $post)
    {
        // Removes specified post
        $post->destroy($post->id);

        // Return a redirect to the home view (blade file) - uses a named route 'home'
        return redirect(route('home'));
    }

    // Validates user input from the creating or updating of posts
    protected function validatePost()
    {
        // Returns a validated request
        return request()->validate([
            'heading' => 'required', // Field is required
            'subheading' => 'required', // Field is required
            'body' => 'required', // Field is required
            'tags' => 'exists:tags,id' // Only tags with an existing id can be used
        ]);
    }
}
