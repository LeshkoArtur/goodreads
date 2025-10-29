<?php

namespace App\Actions\Characters;

use App\Models\Character;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCharacterStats
{
    use AsAction;

    public function handle(Character $character): array
    {
        return [
            'other_names_count' => $character->other_names?->count() ?? 0,
            'fun_facts_count' => $character->fun_facts?->count() ?? 0,
            'links_count' => $character->links?->count() ?? 0,
            'media_images_count' => $character->media_images?->count() ?? 0,
            'has_biography' => ! empty($character->biography),
        ];
    }
}
