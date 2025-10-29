<?php

namespace App\Actions\Tags;

use App\Models\Tag;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTagUsageCount
{
    use AsAction;

    public function handle(Tag $tag): int
    {
        return $tag->posts()->count();
    }
}
