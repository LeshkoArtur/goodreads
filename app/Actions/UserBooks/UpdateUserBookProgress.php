<?php

namespace App\Actions\UserBooks;

use App\Models\UserBook;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUserBookProgress
{
    use AsAction;

    public function handle(UserBook $userBook, int $progressPages): UserBook
    {
        $userBook->update(['progress_pages' => $progressPages]);

        return $userBook->fresh();
    }
}
