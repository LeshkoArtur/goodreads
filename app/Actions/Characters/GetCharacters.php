<?php

namespace App\Actions\Characters;

use App\Data\Character\CharacterIndexData;
use App\Models\Character;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCharacters
{
    use AsAction;

    public function handle(CharacterIndexData $data): LengthAwarePaginator
    {
        $searchQuery = Character::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if (in_array($data->sort, ['name', 'created_at'])) {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'asc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/characters');

        return $paginator;
    }

    private function applyFilters(Builder $query, CharacterIndexData $data): void
    {
        $filters = collect()
                ->when($data->book_id, fn ($collection) => $collection->push("book_id = '{$data->book_id}'"))
                ->when($data->race, fn ($collection) => $collection->push("race = '{$data->race}'"))
                ->when($data->nationality, fn ($collection) => $collection->push("nationality = '{$data->nationality}'"))
                ->when($data->residence, fn ($collection) => $collection->push("residence = '{$data->residence}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
