<?php

namespace App\Models;

use App\Enums\AnswerStatus;
use App\Models\Builders\AuthorAnswerQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperAuthorAnswer
 */
class AuthorAnswer extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'question_id',
        'author_id',
        'content',
        'published_at',
        'status',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => AnswerStatus::class,
    ];

    public function newEloquentBuilder($query): AuthorAnswerQueryBuilder
    {
        return new AuthorAnswerQueryBuilder($query);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(AuthorQuestion::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'question_id' => $this->question_id,
            'author_id' => $this->author_id,
            'content' => $this->content,
            'published_at' => $this->published_at,
            'status' => $this->status,
        ];
    }

    public function searchableAs(): string
    {
        return 'author_answers';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'question_id',
                'author_id',
                'status',
                'published_at',
            ],
            'sortableAttributes' => ['published_at', 'created_at'],
        ];
    }
}
