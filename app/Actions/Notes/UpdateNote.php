<?php

namespace App\Actions\Notes;

use App\DTOs\Note\NoteUpdateDTO;
use App\Models\Note;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateNote
{
    use AsAction;

    /**
     * Оновити існуючу нотатку.
     *
     * @param Note $note
     * @param NoteUpdateDTO $dto
     * @return Note
     */
    public function handle(Note $note, NoteUpdateDTO $dto): Note
    {
        $attributes = [
            'text' => $dto->body,
            'contains_spoilers' => $dto->containsSpoilers,
            'is_private' => $dto->isPrivate,
            'page_number' => $dto->pageNumber,
        ];

        $note->fill(array_filter($attributes, fn($value) => $value !== null));

        $note->save();

        return $note->load(['user', 'book']);
    }
}
