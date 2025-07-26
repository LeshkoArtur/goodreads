<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGenre
 */
class Genre extends Model {
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'description',
        'book_count',
    ];

    protected $casts = [
        'id' => 'string',
        'parent_id' => 'string',
        'book_count' => 'integer',
    ];
    public function books() {return $this->belongsToMany(Book::class); }
    public function parent() {return $this->belongsTo(Parent::class); }
    public function children() {return $this->hasMany(Parent::class); }

}
