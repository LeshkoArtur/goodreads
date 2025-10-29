<?php

namespace App\Actions\Users;

use App\Data\User\UserIndexData;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUsers
{
    use AsAction;

    public function handle(UserIndexData $data): LengthAwarePaginator
    {
        $searchQuery = User::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if (in_array($data->sort, ['username', 'created_at', 'last_login'])) {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/users');

        return $paginator;
    }

    private function applyFilters(Builder $query, UserIndexData $data): void
    {
        $filters = collect()
            ->when($data->location, fn ($collection) => $collection->push("location = '{$data->location}'"))
            ->when($data->min_birthday !== null, fn ($collection) => $collection->push("birthday >= '{$data->min_birthday}'"))
            ->when($data->max_birthday !== null, fn ($collection) => $collection->push("birthday <= '{$data->max_birthday}'"))
            ->when($data->role, fn ($collection) => $collection->push("role = '{$data->role->value}'"))
            ->when($data->gender, fn ($collection) => $collection->push("gender = '{$data->gender->value}'"))
            ->when($data->is_public !== null, fn ($collection) => $collection->push('is_public = '.($data->is_public ? 'true' : 'false')))
            ->when($data->social_media_links, function ($collection) use ($data) {
                $socialMediaFilters = collect($data->social_media_links)
                    ->map(fn ($link) => "social_media_links = '{$link}'")
                    ->implode(' OR ');
                return $collection->push("({$socialMediaFilters})");
            })
            ->when($data->author_ids, fn ($collection) => $collection->push('author_ids IN ['.collect($data->author_ids)->implode(',').']'))
            ->when($data->group_ids, fn ($collection) => $collection->push('group_ids IN ['.collect($data->group_ids)->implode(',').']'));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
