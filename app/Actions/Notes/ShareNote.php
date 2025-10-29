<?php

namespace App\Actions\Notes;

use App\Models\Note;
use Lorisleiva\Actions\Concerns\AsAction;

class ShareNote
{
    use AsAction;

    public function handle(Note $note): Note
    {
        $note->update(['is_private' => false]);

        return $note->fresh();
    }
}
