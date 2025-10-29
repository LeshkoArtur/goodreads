<?php

namespace App\Actions\Tags;

use App\Data\Tag\TagRelationIndexData;
use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTagPosts
{
    use AsAction;

    public function handle(Tag $tag, TagRelationIndexData $data): LengthAwarePaginator
    {
        return $tag->posts()
            ->with(['user', 'tags'])
            ->withCount(['likes', 'comments'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
