<?php

namespace App\Actions\Users;

use App\Data\User\UserRelationIndexData;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserBooks
{
    use AsAction;

    public function handle(User $user, UserRelationIndexData $data): LengthAwarePaginator
    {
        $query = $user->books();

        if ($data->sort && in_array($data->sort, ['created_at', 'start_date', 'read_date', 'rating'])) {
            $query->orderBy($data->sort, $data->direction ?? 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
