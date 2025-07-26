<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPost
 */
class Post extends Model {
    use HasFactory;
    protected $casts = [
        'post_type' => PostType::class,
        'post_status' => PostStatus::class,
        'published_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'book_id',
        'author_id',
        'title',
        'slug',
        'content',
        'cover_image',
        'published_at',
        'post_type',
        'post_status',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function book() { return $this->belongsTo(Book::class); }
    public function author() { return $this->belongsTo(Author::class); }
    public function comments() { return $this->morphMany(Comment::class, 'commentable'); }
    public function likes() { return $this->morphMany(Like::class, 'likeable'); }
    public function favorites() { return $this->morphMany(Favorite::class, 'favoriteable'); }
}
