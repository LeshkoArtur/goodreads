<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Carbon\Carbon;

class BookPublisher extends Pivot
{
    protected $table = 'book_publisher';

    protected $fillable = [
        'book_id',
        'publisher_id',
        'published_date',
        'isbn',
        'circulation',
        'format',
        'cover_type',
        'translator',
        'edition',
        'price',
        'binding',
    ];

    protected $casts = [
        'published_date' => 'date',
        'price' => 'decimal:2',
        'circulation' => 'integer',
    ];
}
