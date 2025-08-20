<?php

namespace App\Models\Builders;

use App\Enums\QuestionStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class AuthorQuestionQueryBuilder extends Builder
{
    /**
     * Питання з певним статусом.
     */
    public function withStatus(QuestionStatus $status): static
    {
        return $this->where('status', $status);
    }

    /**
     * Питання від певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Питання про певного автора.
     */
    public function forAuthor(string $authorId): static
    {
        return $this->where('author_id', $authorId);
    }

    /**
     * Питання, пов’язані з певною книгою.
     */
    public function forBook(string $bookId): static
    {
        return $this->where('book_id', $bookId);
    }

    /**
     * Питання, що містять певний текст (частковий збіг).
     */
    public function withContent(string $content): static
    {
        return $this->where('content', 'like', '%' . $content . '%');
    }

    /**
     * Питання, що мають відповіді.
     */
    public function withAnswers(): static
    {
        return $this->has('answers');
    }
}
