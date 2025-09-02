<?php

namespace App\DTOs\Like;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних лайка.
 */
class LikeUpdateDTO
{
    /**
     * Створює новий екземпляр LikeUpdateDTO.
     *
     * @param string|null $likeableType Тип лайкнутого об’єкта
     * @param string|null $likeableId ID лайкнутого об’єкта
     */
    public function __construct(
        public readonly ?string $likeableType = null,
        public readonly ?string $likeableId = null,
    ) {
    }

    /**
     * Створює новий екземпляр DTO з запиту.
     *
     * @param Request $request HTTP-запит
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            likeableType: $request->input('likeable_type'),
            likeableId: $request->input('likeable_id'),
        );
    }
}
