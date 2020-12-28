<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Find articles corresponding to a tag - many-to-many
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
