<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperPublisher
 */
class Publisher extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'website',
        'country',
        'founded_year',
        'logo',
        'contact_email',
        'phone',
    ];

    protected $casts = [
        'founded_year' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_publisher')
            ->using(BookPublisher::class)
            ->withPivot([
                'published_date',
                'isbn',
                'circulation',
                'format',
                'cover_type',
                'translator',
                'edition',
                'price',
                'binding',
            ]);
    }

}
