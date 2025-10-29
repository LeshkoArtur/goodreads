<?php

namespace App\Actions\Users;

use App\Data\User\UserRelationIndexData;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserFollowers
{
    use AsAction;

    public function handle(User $user, UserRelationIndexData $data): LengthAwarePaginator
    {
        $query = $user->followers();

        if ($data->sort && in_array($data->sort, ['username', 'created_at'])) {
            $query->orderBy($data->sort, $data->direction ?? 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
