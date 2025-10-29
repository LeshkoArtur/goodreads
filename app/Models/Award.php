<?php

namespace App\Models;

use App\Models\Builders\AwardQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperAward
 */
class Award extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'name',
        'year',
        'description',
        'organizer',
        'country',
        'ceremony_date',
    ];

    protected $casts = [
        'year' => 'integer',
        'ceremony_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): AwardQueryBuilder
    {
        return new AwardQueryBuilder($query);
    }

    public function nominations(): HasMany
    {
        return $this->hasMany(Nomination::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->year,
            'description' => $this->description,
            'organizer' => $this->organizer,
            'country' => $this->country,
            'ceremony_date' => $this->ceremony_date,
        ];
    }

    public function searchableAs(): string
    {
        return 'awards';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'year',
                'organizer',
                'country',
                'ceremony_date',
            ],
            'sortableAttributes' => ['name', 'year', 'ceremony_date', 'created_at'],
        ];
    }
}
