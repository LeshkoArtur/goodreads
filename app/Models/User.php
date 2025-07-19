<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin IdeHelperUser
 */
class User extends Model {
    use HasFactory;
    public function authors() { return $this->belongsToMany(Author::class, 'user_authors'); }
    public function shelves() { return $this->hasMany(Shelf::class); }
    public function userBooks() { return $this->hasMany(UserBook::class); }
    public function ratings() { return $this->hasMany(Rating::class); }
    public function quotes() { return $this->hasMany(Quote::class); }
    public function notes() { return $this->hasMany(Note::class); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function likes() { return $this->hasMany(Like::class); }
    public function favorites() { return $this->hasMany(Favorite::class); }
    public function notifications() { return $this->hasMany(Notification::class); }
    public function follows() { return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id'); }
    public function followers() { return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id'); }
    public function viewHistories() { return $this->hasMany(ViewHistory::class); }
    public function groups() { return $this->belongsToMany(Group::class, 'group_members')->withPivot('role', 'status'); }
    public function groupInvitations() { return $this->hasMany(GroupInvitation::class, 'invitee_id'); }
}
