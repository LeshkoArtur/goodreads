<?php

namespace App\DTOs\Award;

use Illuminate\Http\Request;

class AwardStoreDTO
{
    /**
     * @param string $name Назва нагороди
     * @param int $year Рік отримання
     * @param string|null $description Опис
     * @param string|null $organizer Організатор
     * @param string|null $country Країна
     * @param string|null $ceremonyDate Дата церемонії у форматі Y-m-d
     */
    public function __construct(
        public readonly string $name,
        public readonly int $year,
        public readonly ?string $description = null,
        public readonly ?string $organizer = null,
        public readonly ?string $country = null,
        public readonly ?string $ceremonyDate = null
    ) {}

    /**
     * Створити AwardStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            name: $request->input('name'),
            year: (int) $request->input('year'),
            description: $request->input('description'),
            organizer: $request->input('organizer'),
            country: $request->input('country'),
            ceremonyDate: $request->input('ceremony_date')
        );
    }
}
