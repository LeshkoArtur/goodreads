<?php

namespace App\DTOs\Publisher;

use Illuminate\Http\Request;

class PublisherStoreDTO
{
    /**
     * @param string $name Назва видавця
     * @param string|null $description Опис
     * @param string|null $website Вебсайт
     * @param string|null $country Країна
     * @param int|null $foundedYear Рік заснування
     * @param string|null $logo Логотип
     * @param string|null $contactEmail Контактна пошта
     * @param string|null $phone Телефон
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly ?string $website = null,
        public readonly ?string $country = null,
        public readonly ?int $foundedYear = null,
        public readonly ?string $logo = null,
        public readonly ?string $contactEmail = null,
        public readonly ?string $phone = null
    ) {}

    /**
     * Створити PublisherStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            name: $request->input('name'),
            description: $request->input('description'),
            website: $request->input('website'),
            country: $request->input('country'),
            foundedYear: $request->input('founded_year'),
            logo: $request->input('logo'),
            contactEmail: $request->input('contact_email'),
            phone: $request->input('phone')
        );
    }
}
