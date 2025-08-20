<?php

namespace App\DTOs\Store;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних магазину.
 */
class StoreUpdateDTO
{
    /**
     * Створює новий екземпляр StoreUpdateDTO.
     *
     * @param string|null $name Назва магазину
     * @param string|null $country Країна магазину
     * @param string|null $type Тип магазину
     * @param bool|null $isOnline Онлайн/офлайн статус
     * @param string|null $website Вебсайт магазину
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $country = null,
        public readonly ?string $type = null,
        public readonly ?bool $isOnline = null,
        public readonly ?string $website = null,
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
            country: $request->input('country'),
            type: $request->input('type'),
            isOnline: $request->has('is_online') ? $request->boolean('is_online') : null,
            website: $request->input('website'),
        );
    }
}
