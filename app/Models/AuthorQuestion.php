<?php

namespace App\Models;

use App\Enums\QuestionStatus;
use App\Models\Builders\AuthorQuestionQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperAuthorQuestion
 */
class AuthorQuestion extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'user_id',
        'author_id',
        'book_id',
        'content',
        'status',
    ];

    protected $casts = [
        'status' => QuestionStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): AuthorQuestionQueryBuilder
    {
        return new AuthorQuestionQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AuthorAnswer::class, 'question_id');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'author_id' => $this->author_id,
            'book_id' => $this->book_id,
            'content' => $this->content,
            'status' => $this->status,
        ];
    }

    public function searchableAs(): string
    {
        return 'author_questions';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'user_id',
                'author_id',
                'book_id',
                'status',
            ],
            'sortableAttributes' => ['created_at'],
        ];
    }
}
