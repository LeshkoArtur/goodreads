<?php

namespace App\Models;

use App\Enums\ReadingFormat;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperUserBook
 */
class UserBook extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'book_id',
        'shelf_id',
        'start_date',
        'read_date',
        'progress_pages',
        'is_private',
        'rating',
        'notes',
        'reading_format',
    ];

    protected $casts = [
        'start_date' => 'date',
        'read_date' => 'date',
        'is_private' => 'boolean',
        'rating' => 'integer',
        'reading_format' => ReadingFormat::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class);
    }
}
