<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @mixin IdeHelperBookSeries
 */
class BookSeries extends Model
{
    use HasUuids,HasFactory;

    protected $table = 'book_series';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'description',
        'total_books',
        'is_completed',
    ];
}
