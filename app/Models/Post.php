<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\Builders\PostQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @mixin IdeHelperPost
 */
class Post extends Model
{
    use HasFactory, HasSlug, HasUuids, Searchable;

    protected $fillable = [
        'user_id',
        'book_id',
        'author_id',
        'title',
        'slug',
        'content',
        'cover_image',
        'published_at',
        'type',
        'status',
    ];

    protected $casts = [
        'type' => PostType::class,
        'status' => PostStatus::class,
        'published_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): PostQueryBuilder
    {
        return new PostQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'author_id' => $this->author_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'cover_image' => $this->cover_image,
            'published_at' => $this->published_at,
            'type' => $this->type,
            'status' => $this->status,
            'tag_ids' => $this->tags()->pluck('tags.id')->toArray(),
        ];
    }

    public function searchableAs(): string
    {
        return 'posts';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'user_id',
                'book_id',
                'author_id',
                'type',
                'status',
                'published_at',
                'tag_ids',
            ],
            'sortableAttributes' => ['created_at', 'published_at'],
        ];
    }
}
