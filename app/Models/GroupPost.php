<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGroupPost
 */
class GroupPost extends Model {
    use HasFactory;
    public function group() { return $this->belongsTo(Group::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function comments() { return $this->morphMany(Comment::class, 'commentable'); }
    public function likes() { return $this->morphMany(Like::class, 'likeable'); }
    public function favorites() { return $this->morphMany(Favorite::class, 'favoriteable'); }
}
