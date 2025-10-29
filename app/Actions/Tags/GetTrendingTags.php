<?php

namespace App\Actions\Tags;

use App\Data\Tag\TagIndexData;
use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTrendingTags
{
    use AsAction;

    public function handle(TagIndexData $data): LengthAwarePaginator
    {
        return Tag::query()
            ->withCount(['posts' => function ($query) {
                $query->where('created_at', '>=', now()->subDays(7));
            }])
            ->orderBy('posts_count', 'desc')
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
