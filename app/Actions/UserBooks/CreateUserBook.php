<?php

namespace App\Actions\UserBooks;

use App\Data\UserBook\UserBookStoreData;
use App\Models\UserBook;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUserBook
{
    use AsAction;

    public function handle(UserBookStoreData $data): UserBook
    {
        $userBook = new UserBook;
        $userBook->user_id = $data->user_id;
        $userBook->book_id = $data->book_id;
        $userBook->shelf_id = $data->shelf_id;
        $userBook->start_date = $data->start_date;
        $userBook->read_date = $data->read_date;
        $userBook->progress_pages = $data->progress_pages;
        $userBook->is_private = $data->is_private;
        $userBook->rating = $data->rating;
        $userBook->notes = $data->notes;
        $userBook->reading_format = $data->reading_format;
        $userBook->save();

        return $userBook->fresh(['user', 'book', 'shelf']);
    }
}
