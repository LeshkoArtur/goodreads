<?php

namespace App\Models;

use App\Models\Builders\PublisherQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperPublisher
 */
class Publisher extends Model
{
    use HasFactory, HasUuids, Searchable;

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

    public function newEloquentBuilder($query): PublisherQueryBuilder
    {
        return new PublisherQueryBuilder($query);
    }

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

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'website' => $this->website,
            'country' => $this->country,
            'founded_year' => $this->founded_year,
            'logo' => $this->logo,
            'contact_email' => $this->contact_email,
            'phone' => $this->phone,
        ];
    }

    public function searchableAs(): string
    {
        return 'publishers';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'country',
                'founded_year',
                'contact_email',
            ],
            'sortableAttributes' => ['created_at', 'founded_year'],
        ];
    }
}
