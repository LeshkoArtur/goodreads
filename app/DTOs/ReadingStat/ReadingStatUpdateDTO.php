<?php

namespace App\DTOs\ReadingStat;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних статистики читання.
 */
class ReadingStatUpdateDTO
{
    /**
     * Створює новий екземпляр ReadingStatUpdateDTO.
     *
     * @param string|null $status Статус читання
     * @param int|null $pagesRead Кількість прочитаних сторінок
     * @param string|null $startDate Дата початку читання
     * @param string|null $finishDate Дата завершення читання
     */
    public function __construct(
        public readonly ?string $status = null,
        public readonly ?int $pagesRead = null,
        public readonly ?string $startDate = null,
        public readonly ?string $finishDate = null,
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
            status: $request->input('status'),
            pagesRead: $request->input('pages_read') ? (int) $request->input('pages_read') : null,
            startDate: $request->input('start_date'),
            finishDate: $request->input('finish_date'),
        );
    }
}
