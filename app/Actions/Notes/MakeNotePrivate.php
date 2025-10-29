<?php

namespace App\Actions\Notes;

use App\Models\Note;
use Lorisleiva\Actions\Concerns\AsAction;

class MakeNotePrivate
{
    use AsAction;

    public function handle(Note $note): Note
    {
        $note->update(['is_private' => true]);

        return $note->fresh();
    }
}
