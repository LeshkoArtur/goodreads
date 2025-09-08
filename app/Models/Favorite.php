<?php

namespace App\Models;

use App\Models\Builders\FavoriteQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperFavorite
 */
class Favorite extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'user_id',
        'favoriteable_id',
        'favoriteable_type',
    ];

    public function newEloquentBuilder($query): FavoriteQueryBuilder
    {
        return new FavoriteQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function favoriteable(): MorphTo
    {
        return $this->morphTo();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'favoriteable_id' => $this->favoriteable_id,
            'favoriteable_type' => $this->favoriteable_type,
        ];
    }

    public function searchableAs(): string
    {
        return 'favorites';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'user_id',
                'favoriteable_type',
                'favoriteable_id',
            ],
            'sortableAttributes' => ['created_at'],
        ];
    }
}
