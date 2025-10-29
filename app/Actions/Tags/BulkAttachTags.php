<?php

namespace App\Actions\Tags;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class BulkAttachTags
{
    use AsAction;

    /**
     * @param  array<int, string>  $tagIds
     */
    public function handle(array $tagIds, Model $taggable): bool
    {
        if (! method_exists($taggable, 'tags')) {
            return false;
        }

        $tags = Tag::whereIn('id', $tagIds)->get();

        if ($tags->isEmpty()) {
            return false;
        }

        $taggable->tags()->syncWithoutDetaching($tags);

        return true;
    }
}
