<?php

namespace App\Actions\ReadingStats;

use App\DTOs\ReadingStat\ReadingStatUpdateDTO;
use App\Models\ReadingStat;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateReadingStat
{
    use AsAction;

    /**
     * Оновити існуючу статистику читання.
     *
     * @param ReadingStat $readingStat
     * @param ReadingStatUpdateDTO $dto
     * @return ReadingStat
     */
    public function handle(ReadingStat $readingStat, ReadingStatUpdateDTO $dto): ReadingStat
    {
        $attributes = [
            'pages_read' => $dto->pagesRead,
        ];

        $readingStat->fill(array_filter($attributes, fn($value) => $value !== null));

        $readingStat->save();

        return $readingStat->load(['user']);
    }
}
