<?php

namespace App\Actions\Notes;

use App\DTOs\Note\NoteStoreDTO;
use App\Models\Note;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNote
{
    use AsAction;

    /**
     * Створити нову нотатку.
     *
     * @param NoteStoreDTO $dto
     * @return Note
     */
    public function handle(NoteStoreDTO $dto): Note
    {
        $note = new Note();
        $note->user_id = $dto->userId;
        $note->book_id = $dto->bookId;
        $note->text = $dto->text;
        $note->page_number = $dto->pageNumber;
        $note->contains_spoilers = $dto->containsSpoilers;
        $note->is_private = $dto->isPrivate;

        $note->save();

        return $note->load(['user', 'book']);
    }
}
