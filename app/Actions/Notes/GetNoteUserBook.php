<?php

namespace App\Actions\Notes;

use App\Models\Note;
use App\Models\UserBook;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNoteUserBook
{
    use AsAction;

    public function handle(Note $note): ?UserBook
    {
        return UserBook::where('user_id', $note->user_id)
            ->where('book_id', $note->book_id)
            ->first();
    }
}
