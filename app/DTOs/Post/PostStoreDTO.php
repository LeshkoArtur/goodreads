<?php

namespace App\DTOs\Post;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Http\Request;

class PostStoreDTO
{
    use HandlesJsonArrays;
    /**
     * @param string $userId ID користувача
     * @param string|null $bookId ID книги
     * @param string|null $authorId ID автора
     * @param string $title Заголовок
     * @param string $content Текст посту
     * @param string|null $coverImage Обкладинка
     * @param string|null $publishedAt Дата публікації у форматі Y-m-d H:i:s
     * @param array|null $tagIds Масив ID тегів
     * @param PostType|null $type Тип посту
     * @param PostStatus|null $status Статус посту
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $title,
        public readonly string $content,
        public readonly ?string $bookId = null,
        public readonly ?string $authorId = null,
        public readonly ?string $coverImage = null,
        public readonly ?string $publishedAt = null,
        public readonly ?array $tagIds = null,
        public readonly ?PostType $type = null,
        public readonly ?PostStatus $status = null
    ) {}

    /**
     * Створити PostStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            title: $request->input('title'),
            content: $request->input('content'),
            bookId: $request->input('book_id'),
            authorId: $request->input('author_id'),
            coverImage: $request->input('cover_image'),
            publishedAt: $request->input('published_at'),
            tagIds: self::processJsonArray($request->input('tag_ids')),
            type: $request->input('type') ? PostType::from($request->input('type')) : null,
            status: $request->input('status') ? PostStatus::from($request->input('status')) : null
        );
    }
}
