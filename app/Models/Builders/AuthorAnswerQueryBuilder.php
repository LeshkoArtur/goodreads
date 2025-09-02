<?php

namespace App\Models\Builders;

use App\Enums\AnswerStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class AuthorAnswerQueryBuilder extends Builder
{
    /**
     * Відповіді з певним статусом.
     */
    public function withStatus(AnswerStatus $status): static
    {
        return $this->where('status', $status);
    }

    /**
     * Відповіді, опубліковані після певної дати.
     */
    public function publishedAfter(Carbon $date): static
    {
        return $this->where('published_at', '>', $date->toDateTimeString());
    }

    /**
     * Відповіді на конкретне питання.
     */
    public function forQuestion(string $questionId): static
    {
        return $this->where('question_id', $questionId);
    }

    /**
     * Відповіді від певного автора.
     */
    public function byAuthor(string $authorId): static
    {
        return $this->where('author_id', $authorId);
    }

    /**
     * Відповіді, що містять певний текст (частковий збіг).
     */
    public function withContent(string $content): static
    {
        return $this->where('content', 'like', '%' . $content . '%');
    }
}
