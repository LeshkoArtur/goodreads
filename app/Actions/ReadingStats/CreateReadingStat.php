<?php

namespace App\Actions\ReadingStats;

use App\DTOs\ReadingStat\ReadingStatStoreDTO;
use App\Models\ReadingStat;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateReadingStat
{
    use AsAction;

    /**
     * Створити нову статистику читання.
     *
     * @param ReadingStatStoreDTO $dto
     * @return ReadingStat
     */
    public function handle(ReadingStatStoreDTO $dto): ReadingStat
    {
        $readingStat = new ReadingStat();
        $readingStat->user_id = $dto->userId;
        $readingStat->year = $dto->year;
        $readingStat->books_read = $dto->booksRead;
        $readingStat->pages_read = $dto->pagesRead;
        $readingStat->genres_read = $dto->genresRead;

        $readingStat->save();

        return $readingStat->load(['user']);
    }
}
