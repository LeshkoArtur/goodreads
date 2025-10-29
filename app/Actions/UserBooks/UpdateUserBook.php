<?php

namespace App\Actions\UserBooks;

use App\Data\UserBook\UserBookUpdateData;
use App\Models\UserBook;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUserBook
{
    use AsAction;

    public function handle(UserBook $userBook, UserBookUpdateData $data): UserBook
    {
        $userBook->update(array_filter([
            'user_id' => $data->user_id,
            'book_id' => $data->book_id,
            'shelf_id' => $data->shelf_id,
            'start_date' => $data->start_date,
            'read_date' => $data->read_date,
            'progress_pages' => $data->progress_pages,
            'is_private' => $data->is_private,
            'rating' => $data->rating,
            'notes' => $data->notes,
            'reading_format' => $data->reading_format,
        ], fn ($value) => $value !== null));

        return $userBook->fresh(['user', 'book', 'shelf']);
    }
}
