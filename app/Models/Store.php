<?php

namespace App\Models;

use App\Models\Builders\StoreQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperStore
 */
class Store extends Model
{
    use HasFactory, HasUuids;

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
}
