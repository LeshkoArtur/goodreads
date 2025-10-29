<?php

namespace App\Actions\NominationEntries;

use App\Data\NominationEntry\NominationEntryIndexData;
use App\Models\NominationEntry;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNominationEntries
{
    use AsAction;

    public function handle(NominationEntryIndexData $data): LengthAwarePaginator
    {
        $searchQuery = NominationEntry::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if ($data->sort === 'created_at') {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/nomination-entries');

        return $paginator;
    }

    private function applyFilters(Builder $query, NominationEntryIndexData $data): void
    {
        $filters = collect()
                ->when($data->nomination_id, fn ($collection) => $collection->push("nomination_id = '{$data->nomination_id}'"))
                ->when($data->book_id, fn ($collection) => $collection->push("book_id = '{$data->book_id}'"))
                ->when($data->author_id, fn ($collection) => $collection->push("author_id = '{$data->author_id}'"))
                ->when($data->status, fn ($collection) => $collection->push("status = '{$data->status->value}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
