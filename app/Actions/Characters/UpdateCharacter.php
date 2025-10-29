<?php

namespace App\Actions\Characters;

use App\Data\Character\CharacterUpdateData;
use App\Models\Character;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCharacter
{
    use AsAction;

    public function handle(Character $character, CharacterUpdateData $data): Character
    {
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
