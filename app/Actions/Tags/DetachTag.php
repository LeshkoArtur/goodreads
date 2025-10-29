<?php

namespace App\Actions\Tags;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class DetachTag
{
    use AsAction;

    public function handle(Tag $tag, Model $taggable): bool
    {
        if (! method_exists($taggable, 'tags')) {
            return false;
        }

        if (! $taggable->tags()->where('tag_id', $tag->id)->exists()) {
            return false;
        }

        $taggable->tags()->detach($tag);

        return true;
    }
}
