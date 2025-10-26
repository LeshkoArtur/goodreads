<?php

namespace App\Models;

use App\Models\Builders\TagQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperTag
 */
class Tag extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'name',
    ];

    public function newEloquentBuilder($query): TagQueryBuilder
    {
        return new TagQueryBuilder($query);
    }

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'taggable_count' => $this->posts()->count(),
        ];
    }

    public function searchableAs(): string
    {
        return 'tags';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'taggable_count',
            ],
            'sortableAttributes' => ['created_at', 'name', 'taggable_count'],
        ];
    }
}

