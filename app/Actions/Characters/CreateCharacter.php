<?php

namespace App\Actions\Characters;

use App\Data\Character\CharacterStoreData;
use App\Models\Character;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCharacter
{
    use AsAction;

    public function handle(CharacterStoreData $data): Character
    {
        $character = new Character;
        $character->book_id = $data->book_id;
        $character->name = $data->name;
        $character->other_names = $data->other_names;
        $character->race = $data->race;
        $character->nationality = $data->nationality;
        $character->residence = $data->residence;
        $character->biography = $data->biography;
        $character->fun_facts = $data->fun_facts;
        $character->links = $data->links;
        $character->media_images = $data->media_images;
        $character->save();

        return $character->fresh(['book']);
    }
}
