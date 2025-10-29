<?php

namespace App\Actions\UserBooks;

use App\Data\UserBook\UserBookRelationIndexData;
use App\Models\UserBook;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserBookQuotes
{
    use AsAction;

    public function handle(UserBook $userBook, UserBookRelationIndexData $data): LengthAwarePaginator
    {
        $query = $userBook->book->quotes()
            ->where('user_id', $userBook->user_id)
            ->with(['user', 'book']);

        if ($data->sort && in_array($data->sort, ['created_at', 'page_number'])) {
            $query->orderBy($data->sort, $data->direction ?? 'asc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
