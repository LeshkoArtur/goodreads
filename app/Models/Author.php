<?php

namespace App\Models;

use App\Enums\TypeOfWork;
use App\Models\Builders\AuthorQueryBuilder;
use App\Models\Traits\HasFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\{
    BelongsToMany,
    HasMany
};
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperAuthor
 */
class Author extends Model
{
    use HasFactory, HasUuids, Searchable, HasFiles;

    protected $fillable = [
        'name',
        'bio',
        'birth_date',
        'birth_place',
        'nationality',
        'website',
        'profile_picture',
        'death_date',
        'social_media_links',
        'media_images',
        'media_videos',
        'fun_facts',
        'type_of_work',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'type_of_work' => TypeOfWork::class,
        'social_media_links' => AsCollection::class,
        'media_images' => AsCollection::class,
        'media_videos' => AsCollection::class,
        'fun_facts' => AsCollection::class,
    ];

    public function newEloquentBuilder($query): AuthorQueryBuilder
    {
        return new AuthorQueryBuilder($query);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'author_user');
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'author_book');
    }

    public function nominations(): HasMany
    {
        return $this->hasMany(NominationEntry::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(AuthorQuestion::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AuthorAnswer::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'bio' => $this->bio,
            'birth_date' => $this->birth_date,
            'birth_place' => $this->birth_place,
            'nationality' => $this->nationality,
            'website' => $this->website,
            'profile_picture' => $this->profile_picture,
            'death_date' => $this->death_date,
            'social_media_links' => $this->social_media_links,
            'media_images' => $this->media_images,
            'media_videos' => $this->media_videos,
            'fun_facts' => $this->fun_facts,
            'type_of_work' => $this->type_of_work,
            'user_ids' => $this->users()->pluck('users.id')->toArray(),
            'book_ids' => $this->books()->pluck('books.id')->toArray(),
        ];
    }

    public function searchableAs(): string
    {
        return 'authors';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'nationality',
                'birth_date',
                'death_date',
                'type_of_work',
                'social_media_links',
                'user_ids',
                'book_ids',
            ],
            'sortableAttributes' => ['name', 'birth_date', 'created_at'],
        ];
    }
}
