<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Models\Builders\BookOfferQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperBookOffer
 */
class BookOffer extends Model
{
    use HasFactory, HasUuids;

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
}
