<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCharacter
 */
class Character extends Model {
    use HasFactory;
    protected $casts = [
        'book_id' => 'string',
        'other_names' => 'array',
        'fun_facts' => 'array',
        'links' => 'array',
        'media_images' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'book_id',
        'name',
        'other_names',
        'race',
        'nationality',
        'residence',
        'biography',
        'fun_facts',
        'links',
        'media_images',
    ];
    public function book() { return $this->belongsTo(Book::class); }
}
