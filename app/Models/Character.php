<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperCharacter
 */
class Character extends Model
{
    use HasFactory, HasUuids;

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

    protected $casts = [
        'book_id' => 'string',
        'other_names' => AsCollection::class,
        'fun_facts' => AsCollection::class,
        'links' => AsCollection::class,
        'media_images' => AsCollection::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
