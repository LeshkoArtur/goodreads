<?php

namespace App\Models;

use App\Enums\QuestionStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperAuthorQuestion
 */
class AuthorQuestion extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'author_id',
        'book_id',
        'content',
        'question_status',
    ];

    protected $casts = [
        'question_status' => QuestionStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

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
}
