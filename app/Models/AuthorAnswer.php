<?php

namespace App\Models;

use App\Enums\AnswerStatus;
use App\Models\Builders\AuthorAnswerQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperAuthorAnswer
 */
class AuthorAnswer extends Model
{
    use HasFactory, HasUuids;

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
}
