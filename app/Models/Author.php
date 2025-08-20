<?php

namespace App\Models;

use App\Enums\TypeOfWork;
use App\Models\Builders\AuthorQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\{
    BelongsToMany,
    HasMany
};

/**
 * @mixin IdeHelperAuthor
 */
class Author extends Model
{
    use HasFactory, HasUuids;

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
}
