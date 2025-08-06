<?php

namespace App\Models;

use App\Enums\NominationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperNominationEntry
 */
class NominationEntry extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nomination_id',
        'book_id',
        'author_id',
        'status',
    ];

    protected $casts = [
        'status' => NominationStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function nomination(): BelongsTo
    {
        return $this->belongsTo(Nomination::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
