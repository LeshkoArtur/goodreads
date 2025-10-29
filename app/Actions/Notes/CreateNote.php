<?php

namespace App\Actions\Notes;

use App\Data\Note\NoteStoreData;
use App\Models\Note;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNote
{
    use AsAction;

    public function handle(NoteStoreData $data): Note
    {
        $note = new Note;
        $note->user_id = $data->user_id;
        $note->book_id = $data->book_id;
        $note->text = $data->text;
        $note->page_number = $data->page_number;
        $note->contains_spoilers = $data->contains_spoilers;
        $note->is_private = $data->is_private;
        $note->save();

        return $note->fresh(['user', 'book']);
    }
}
