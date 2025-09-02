<?php

namespace App\DTOs\Like;

use Illuminate\Http\Request;

class LikeStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param string $likeableId ID об'єкта, що лайкається
     * @param string $likeableType Тип об'єкта, що лайкається
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $likeableId,
        public readonly string $likeableType
    ) {}

    /**
     * Створити LikeStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            likeableId: $request->input('likeable_id'),
            likeableType: $request->input('likeable_type')
        );
    }
}
