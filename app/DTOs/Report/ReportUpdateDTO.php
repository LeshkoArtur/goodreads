<?php

namespace App\DTOs\Report;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних звіту.
 */
class ReportUpdateDTO
{
    /**
     * Створює новий екземпляр ReportUpdateDTO.
     *
     * @param string|null $reason Причина звіту
     * @param string|null $description Опис звіту
     * @param string|null $status Статус звіту
     */
    public function __construct(
        public readonly ?string $reason = null,
        public readonly ?string $description = null,
        public readonly ?string $status = null,
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
            reason: $request->input('reason'),
            description: $request->input('description'),
            status: $request->input('status'),
        );
    }
}
