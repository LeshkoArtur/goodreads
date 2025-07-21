<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPost
 */
class Post extends Model {
    use HasFactory;
    public function user() { return $this->belongsTo(User::class); }
    public function book() { return $this->belongsTo(Book::class); }
    public function author() { return $this->belongsTo(Author::class); }
    public function comments() { return $this->morphMany(Comment::class, 'commentable'); }
    public function likes() { return $this->morphMany(Like::class, 'likeable'); }
    public function favorites() { return $this->morphMany(Favorite::class, 'favoriteable'); }
}
