<?php

namespace App\Models;

use App\Models\Builders\NominationQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperNomination
 */
class Nomination extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'award_id',
        'name',
        'description',
    ];

    public function newEloquentBuilder($query): NominationQueryBuilder
    {
        return new NominationQueryBuilder($query);
    }

    public function award(): BelongsTo
    {
        return $this->belongsTo(Award::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(NominationEntry::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'award_id' => $this->award_id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function searchableAs(): string
    {
        return 'nominations';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'award_id',
            ],
            'sortableAttributes' => ['created_at'],
        ];
    }
}
