<?php

namespace App\Actions\UserBooks;

use App\Models\UserBook;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUserBookStatus
{
    use AsAction;

    public function handle(UserBook $userBook, string $shelfId): UserBook
    {
        $userBook->update(['shelf_id' => $shelfId]);

        return $userBook->fresh();
    }
}
