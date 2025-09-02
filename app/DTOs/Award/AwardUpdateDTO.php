<?php

namespace App\DTOs\Award;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних нагороди.
 */
class AwardUpdateDTO
{
    /**
     * Створює новий екземпляр AwardUpdateDTO.
     *
     * @param string|null $name Назва нагороди
     * @param int|null $year Рік нагороди
     * @param string|null $organizer Організатор нагороди
     * @param string|null $country Країна нагороди
     * @param string|null $ceremonyDate Дата церемонії
     * @param string|null $description Опис нагороди
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?int $year = null,
        public readonly ?string $organizer = null,
        public readonly ?string $country = null,
        public readonly ?string $ceremonyDate = null,
        public readonly ?string $description = null,
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
            name: $request->input('name'),
            year: $request->input('year') ? (int) $request->input('year') : null,
            organizer: $request->input('organizer'),
            country: $request->input('country'),
            ceremonyDate: $request->input('ceremony_date'),
            description: $request->input('description'),
        );
    }
}
