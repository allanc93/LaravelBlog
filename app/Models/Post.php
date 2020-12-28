<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Assign properties that can be mass assigned
    protected $fillable = ['heading', 'subheading', 'body'];

    // protected $timestamps = false;

    // When you don't want any automatic protection
    // protected $guarded = [];

    // To match wildcard to a slug, instead of id
    // public function getRouteKeyName()
    // {
    //     return 'slug'; // Article::where('slug', $article)->first();
    // }

    // To find an article belonging to a user
    // public function user()
    // {
    //     return $this->belongsTo(User::class); // Laravel assumes FK is user_id
    // }

    // To find a post belonging to an author (user)
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id'); // Override the foreign key (would expect author_id)
    }

    // Find tags corresponding to a post - many-to-many
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
