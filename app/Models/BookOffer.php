<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Models\Builders\BookOfferQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperBookOffer
 */
class BookOffer extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'book_id',
        'store_id',
        'price',
        'currency',
        'referral_url',
        'availability',
        'status',
        'last_updated_at',
    ];

    protected $casts = [
        'book_id' => 'string',
        'store_id' => 'string',
        'price' => 'decimal:2',
        'currency' => Currency::class,
        'status' => OfferStatus::class,
        'last_updated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): BookOfferQueryBuilder
    {
        return new BookOfferQueryBuilder($query);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'book_id' => $this->book_id,
            'store_id' => $this->store_id,
            'price' => $this->price,
            'currency' => $this->currency,
            'referral_url' => $this->referral_url,
            'availability' => $this->availability,
            'status' => $this->status,
            'last_updated_at' => $this->last_updated_at,
        ];
    }

    public function searchableAs(): string
    {
        return 'book_offers';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'book_id',
                'store_id',
                'price',
                'currency',
                'status',
                'last_updated_at',
            ],
            'sortableAttributes' => ['price', 'last_updated_at', 'created_at'],
        ];
    }
}
