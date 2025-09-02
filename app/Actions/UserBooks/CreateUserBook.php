<?php

namespace App\Actions\UserBooks;

use App\DTOs\UserBook\UserBookStoreDTO;
use App\Models\UserBook;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUserBook
{
    use AsAction;

    /**
     * Створити новий зв’язок між користувачем та книгою.
     *
     * @param UserBookStoreDTO $dto
     * @return UserBook
     */
    public function handle(UserBookStoreDTO $dto): UserBook
    {
        $userBook = new UserBook();
        $userBook->user_id = $dto->userId;
        $userBook->book_id = $dto->bookId;
        $userBook->shelf_id = $dto->shelfId;
        $userBook->start_date = $dto->startDate;
        $userBook->read_date = $dto->readDate;
        $userBook->progress_pages = $dto->progressPages;
        $userBook->is_private = $dto->isPrivate;
        $userBook->rating = $dto->rating;
        $userBook->notes = $dto->notes;
        $userBook->reading_format = $dto->readingFormat?->value;

        $userBook->save();

        return $userBook->load(['user', 'book', 'shelf']);
    }
}
