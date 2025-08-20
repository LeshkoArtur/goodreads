<?php

namespace App\DTOs\Nomination;

use Illuminate\Http\Request;

class NominationStoreDTO
{
    /**
     * @param string $awardId ID нагороди
     * @param string $name Назва номінації
     * @param string|null $description Опис
     */
    public function __construct(
        public readonly string $awardId,
        public readonly string $name,
        public readonly ?string $description = null
    ) {}

    /**
     * Створити NominationStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            awardId: $request->input('award_id'),
            name: $request->input('name'),
            description: $request->input('description')
        );
    }
}
