<?php

namespace App\Actions\Characters;

use App\DTOs\Character\CharacterStoreDTO;
use App\Models\Character;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCharacter
{
    use AsAction;

    /**
     * Створити нового персонажа.
     *
     * @param CharacterStoreDTO $dto
     * @return Character
     */
    public function handle(CharacterStoreDTO $dto): Character
    {
        $character = new Character();
        $character->book_id = $dto->bookId;
        $character->name = $dto->name;
        $character->other_names = $dto->otherNames;
        $character->race = $dto->race;
        $character->nationality = $dto->nationality;
        $character->residence = $dto->residence;
        $character->biography = $dto->biography;
        $character->fun_facts = $dto->funFacts;
        $character->links = $dto->links;
        $character->media_images = $dto->mediaImages;

        if ($dto->mediaImages) {
            $character->media_images = $character->handleFileUpload($dto->mediaImages, 'character_images');
        }

        $character->save();

        return $character->load(['book']);
    }
}
