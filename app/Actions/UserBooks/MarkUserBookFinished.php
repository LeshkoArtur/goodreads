<?php

namespace App\Actions\UserBooks;

use App\Models\UserBook;
use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class MarkUserBookFinished
{
    use AsAction;

    public function handle(UserBook $userBook): UserBook
    {
        $userBook->update([
            'read_date' => Carbon::now(),
            'progress_pages' => $userBook->book->page_count ?? $userBook->progress_pages,
        ]);

        return $userBook->fresh();
    }
}
