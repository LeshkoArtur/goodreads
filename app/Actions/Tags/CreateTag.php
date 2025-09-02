<?php

namespace App\Actions\Tags;

use App\DTOs\Tag\TagStoreDTO;
use App\Models\Tag;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateTag
{
    use AsAction;

    /**
     * Створити новий тег.
     *
     * @param TagStoreDTO $dto
     * @return Tag
     */
    public function handle(TagStoreDTO $dto): Tag
    {
        $tag = new Tag();
        $tag->name = $dto->name;

        $tag->save();

        return $tag->load(['posts']);
    }
}
