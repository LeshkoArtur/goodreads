<?php

namespace App\Actions\Authors;

use App\DTOs\Author\AuthorUpdateDTO;
use App\Models\Author;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAuthor
{
    use AsAction;

    /**
     * Оновити існуючого автора.
     *
     * @param Author $author
     * @param AuthorUpdateDTO $dto
     * @return Author
     */
    public function handle(Author $author, AuthorUpdateDTO $dto): Author
    {
        $attributes = [
            'name' => $dto->name,
            'nationality' => $dto->nationality,
            'birth_date' => $dto->birthDate,
            'death_date' => $dto->deathDate,
            'type_of_work' => $dto->typeOfWork,
            'social_media_links' => $dto->socialMediaLinks,
            'bio' => $dto->bio,
        ];

        $author->fill(array_filter($attributes, fn($value) => $value !== null));

        $author->save();

        $this->syncRelations($author, $dto);

        return $author->load(['users', 'books']);
    }

    /**
     * Синхронізувати зв’язки автора (користувачі, книги).
     *
     * @param Author $author
     * @param AuthorUpdateDTO $dto
     * @return void
     */
    private function syncRelations(Author $author, AuthorUpdateDTO $dto): void
    {
        if ($dto->userIds !== null) {
            $author->users()->sync($dto->userIds);
        }

    }
}
