<?php

namespace App\Actions\Notes;

use App\Data\Note\NoteUpdateData;
use App\Models\Note;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateNote
{
    use AsAction;

    public function handle(Note $note, NoteUpdateData $data): Note
    {
        $note->update(array_filter([
            'user_id' => $data->user_id,
            'book_id' => $data->book_id,
            'text' => $data->text,
            'page_number' => $data->page_number,
            'contains_spoilers' => $data->contains_spoilers,
            'is_private' => $data->is_private,
        ], fn ($value) => $value !== null));

        return $note->fresh(['user', 'book']);
    }
}
