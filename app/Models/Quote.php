<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperQuote
 */
class Quote extends Model {
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'text',
        'page_number',
        'contains_spoilers',
        'is_public',
    ];

    protected $casts = [
        'page_number' => 'integer',
        'contains_spoilers' => 'boolean',
        'is_public' => 'boolean',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function book() { return $this->belongsTo(Book::class); }
    public function comments() { return $this->morphMany(Comment::class, 'commentable'); }
    public function likes() { return $this->morphMany(Like::class, 'likeable'); }
    public function favorites() { return $this->morphMany(Favorite::class, 'favoriteable'); }
}
