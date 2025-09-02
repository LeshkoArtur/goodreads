<?php

namespace App\DTOs\Comment;

use Illuminate\Http\Request;

class CommentStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param string $commentableType Тип коментованого об'єкта
     * @param string $commentableId ID коментованого об'єкта
     * @param string $content Текст коментаря
     * @param string|null $parentId ID батьківського коментаря
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $commentableType,
        public readonly string $commentableId,
        public readonly string $content,
        public readonly ?string $parentId = null
    ) {}

    /**
     * Створити CommentStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            commentableType: $request->input('commentable_type'),
            commentableId: $request->input('commentable_id'),
            content: $request->input('content'),
            parentId: $request->input('parent_id')
        );
    }
}
