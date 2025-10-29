<?php

namespace App\Actions\UserBooks;

use App\Data\UserBook\UserBookRelationIndexData;
use App\Models\UserBook;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserBookRatings
{
    use AsAction;

    public function handle(UserBook $userBook, UserBookRelationIndexData $data): LengthAwarePaginator
    {
        $query = $userBook->book->ratings()
            ->where('user_id', $userBook->user_id)
            ->with(['user', 'book']);

        if ($data->sort && in_array($data->sort, ['created_at', 'rating'])) {
            $query->orderBy($data->sort, $data->direction ?? 'desc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
