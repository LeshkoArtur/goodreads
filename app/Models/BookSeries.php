<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperBookSeries
 */
class BookSeries extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'total_books',
        'is_completed',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'series_id');
    }
}
