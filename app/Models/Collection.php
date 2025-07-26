<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCollection
 */
class Collection extends Model {
    use HasFactory;
    protected $casts = [
        'user_id' => 'string',
        'is_public' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'cover_image',
        'is_public',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function books() {
        return $this->belongsToMany(Book::class, 'collection_books')->withPivot('order_index');
    }
}
