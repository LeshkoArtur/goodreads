<?php

namespace App\Actions\Users;

use App\Data\User\UserRelationIndexData;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserGroups
{
    use AsAction;

    public function handle(User $user, UserRelationIndexData $data): LengthAwarePaginator
    {
        $query = $user->groups();

        if ($data->sort && in_array($data->sort, ['name', 'created_at'])) {
            $query->orderBy($data->sort, $data->direction ?? 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
