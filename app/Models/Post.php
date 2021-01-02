<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Assign properties that can be mass assigned
    protected $fillable = ['heading', 'subheading', 'body'];

    // Find a post belonging to an author (user)
    public function author()
    {
        // A post belongs to a user
        return $this->belongsTo(User::class, 'user_id'); // Override the FK - would expect author_id, but in this case user_id is used
    }

    // Find tags corresponding to a post - many-to-many
    public function tags()
    {
        // Many posts can belong to many tags
        return $this->belongsToMany(Tag::class)->withTimestamps(); // Fills timestamp columns
    }
}
