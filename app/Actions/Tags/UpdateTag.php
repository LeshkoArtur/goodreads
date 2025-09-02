<?php

namespace App\Actions\Tags;

use App\DTOs\Tag\TagUpdateDTO;
use App\Models\Tag;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateTag
{
    use AsAction;

    /**
     * Оновити існуючий тег.
     *
     * @param Tag $tag
     * @param TagUpdateDTO $dto
     * @return Tag
     */
    public function handle(Tag $tag, TagUpdateDTO $dto): Tag
    {
        $attributes = [
            'name' => $dto->name,
        ];

        $tag->fill(array_filter($attributes, fn($value) => $value !== null));

        $tag->save();

        return $tag->load(['posts']);
    }
}
