<?php

namespace App\Models;

use App\Models\Builders\CharacterQueryBuilder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperCharacter
 */
class Character extends Model
{
    use HasFactory, HasUuids, Searchable;

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

    public function newEloquentBuilder($query): CharacterQueryBuilder
    {
        return new CharacterQueryBuilder($query);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'book_id' => $this->book_id,
            'name' => $this->name,
            'other_names' => $this->other_names,
            'race' => $this->race,
            'nationality' => $this->nationality,
            'residence' => $this->residence,
            'biography' => $this->biography,
            'fun_facts' => $this->fun_facts,
            'links' => $this->links,
            'media_images' => $this->media_images,
        ];
    }

    public function searchableAs(): string
    {
        return 'characters';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'book_id',
                'race',
                'nationality',
                'residence',
                'other_names',
            ],
            'sortableAttributes' => ['name', 'created_at'],
        ];
    }
}
