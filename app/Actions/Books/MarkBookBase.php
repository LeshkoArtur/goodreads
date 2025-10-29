<?php

namespace App\Actions\Books;

use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;
use App\Models\UserBook;
use Lorisleiva\Actions\Concerns\AsAction;

abstract class MarkBookBase
{
    use AsAction;

    abstract protected function getShelfName(): string;

    protected function getAdditionalUpdateData(): array
    {
        return [];
    }

    protected function getAdditionalCreateData(): array
    {
        return [];
    }

    public function handle(Book $book, User $user): UserBook
    {
        $shelf = Shelf::whereNull('user_id')
            ->where('name', $this->getShelfName())
            ->firstOrFail();

        $existingUserBook = UserBook::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if ($existingUserBook) {
            $existingUserBook->update(array_merge(
                ['shelf_id' => $shelf->id],
                $this->getAdditionalUpdateData()
            ));

            return $existingUserBook->fresh(['shelf', 'book']);
        }

        $userBook = UserBook::create(array_merge(
            [
                'user_id' => $user->id,
                'book_id' => $book->id,
                'shelf_id' => $shelf->id,
            ],
            $this->getAdditionalCreateData()
        ));

        return $userBook->load(['shelf', 'book']);
    }
}
