<?php

namespace App\Actions\Shelves;

use App\Data\Shelf\ShelfRelationIndexData;
use App\Models\Shelf;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetShelfBooks
{
    use AsAction;

    public function handle(Shelf $shelf, ShelfRelationIndexData $data): LengthAwarePaginator
    {
        $query = $shelf->books()->withPivot([
            'user_id',
            'start_date',
            'read_date',
            'progress_pages',
            'is_private',
            'rating',
            'notes',
            'reading_format',
            'created_at',
            'updated_at',
        ]);

        if ($data->sort && in_array($data->sort, ['title', 'created_at', 'average_rating'])) {
            $query->orderBy($data->sort, $data->direction ?? 'asc');
        }

        return $query->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );
    }
}
