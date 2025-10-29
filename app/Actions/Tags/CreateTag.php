<?php

namespace App\Actions\Tags;

use App\Data\Tag\TagStoreData;
use App\Models\Tag;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateTag
{
    use AsAction;

    public function handle(TagStoreData $data): Tag
    {
        $tag = new Tag;
        $tag->name = $data->name;
        $tag->save();

        return $tag->fresh(['posts']);
    }
}
