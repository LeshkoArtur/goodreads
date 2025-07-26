<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperNote
 */
class Note extends Model {
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'text',
        'page_number',
        'contains_spoilers',
        'is_private',
    ];

    protected $casts = [
        'contains_spoilers' => 'boolean',
        'is_private' => 'boolean',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function book() { return $this->belongsTo(Book::class); }
}
