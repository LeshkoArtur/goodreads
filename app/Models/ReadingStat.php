<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperReadingStat
 */
class ReadingStat extends Model {
    use HasFactory;
    protected $fillable = [
        'user_id',
        'year',
        'books_read',
        'pages_read',
        'genres_read',
    ];

    protected $casts = [
        'year' => 'integer',
        'books_read' => 'integer',
        'pages_read' => 'integer',
        'genres_read' => 'array',
        'updated_at' => 'datetime',
    ];
    public function user() { return $this->belongsTo(User::class); }
}
