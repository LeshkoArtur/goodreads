<?php

namespace App\Models;

use App\Models\Builders\StoreQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperStore
 */
class Store extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'name',
        'logo_url',
        'region',
        'website_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): StoreQueryBuilder
    {
        return new StoreQueryBuilder($query);
    }

    public function bookOffers(): HasMany
    {
        return $this->hasMany(BookOffer::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo_url' => $this->logo_url,
            'region' => $this->region,
            'website_url' => $this->website_url,
        ];
    }

    public function searchableAs(): string
    {
        return 'stores';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'region',
            ],
            'sortableAttributes' => ['created_at', 'name'],
        ];
    }
}
