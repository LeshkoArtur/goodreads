<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperComment
 */
class Comment extends Model {
    use HasFactory;
    protected $fillable = [
        'user_id',
        'commentable_type',
        'commentable_id',
        'content',
        'parent_id',
    ];

    protected $casts = [
        'user_id' => 'string',
        'parent_id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function commentable() { return $this->morphTo(); }
    public function replies() { return $this->hasMany(Comment::class, 'parent_id'); }
    public function parent() { return $this->belongsTo(Comment::class, 'parent_id'); }
}
