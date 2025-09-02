<?php

namespace App\DTOs\AuthorQuestion;

use App\Enums\QuestionStatus;
use Illuminate\Http\Request;

class AuthorQuestionStoreDTO
{
    /**
     * @param string $userId ID користувача, що задає питання
     * @param string $authorId ID автора, до якого питання
     * @param string $content Текст питання
     * @param string|null $bookId ID книги (опційно)
     * @param QuestionStatus|null $status Статус питання
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $authorId,
        public readonly string $content,
        public readonly ?string $bookId = null,
        public readonly ?QuestionStatus $status = null
    ) {}

    /**
     * Створити AuthorQuestionStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            authorId: $request->input('author_id'),
            content: $request->input('content'),
            bookId: $request->input('book_id'),
            status: $request->input('status')
                ? QuestionStatus::from($request->input('status'))
                : null
        );
    }
}
