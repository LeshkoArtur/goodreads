<?php

namespace App\DTOs\Publisher;

use App\DTOs\Traits\HandlesArrayInput;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних видавця.
 */
class PublisherUpdateDTO
{
    use HandlesArrayInput;

    /**
     * Створює новий екземпляр PublisherUpdateDTO.
     *
     * @param string|null $name Назва видавця
     * @param string|null $country Країна видавця
     * @param int|null $foundedYear Рік заснування
     * @param array|null $contactEmails Контактні email
     * @param string|null $description Опис видавця
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $country = null,
        public readonly ?int $foundedYear = null,
        public readonly ?array $contactEmails = null,
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
            country: $request->input('country'),
            foundedYear: $request->input('founded_year') ? (int) $request->input('founded_year') : null,
            contactEmails: self::processArrayInput($request, 'contact_emails'),
            description: $request->input('description'),
        );
    }
}
