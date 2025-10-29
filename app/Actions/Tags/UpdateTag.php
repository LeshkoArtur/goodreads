<?php

namespace App\Actions\Tags;

use App\Data\Tag\TagUpdateData;
use App\Models\Tag;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateTag
{
    use AsAction;

    public function handle(Tag $tag, TagUpdateData $data): Tag
    {
        $tag->update(array_filter([
            'name' => $data->name,
        ], fn ($value) => $value !== null));

        return $tag->fresh(['posts']);
    }
}
