<?php

namespace App\Actions\AuthorAnswers;

use App\Data\AuthorAnswer\AuthorAnswerIndexData;
use App\Models\AuthorAnswer;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthorAnswers
{
    use AsAction;

    public function handle(AuthorAnswerIndexData $data): LengthAwarePaginator
    {
        $searchQuery = AuthorAnswer::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['published_at', 'created_at']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/author-answers');

        return $paginator;
    }

    private function applyFilters(Builder $query, AuthorAnswerIndexData $data): void
    {
        $filters = collect()
                ->when($data->question_id, fn ($collection) => $collection->push("question_id = '{$data->question_id}'"))
                ->when($data->author_id, fn ($collection) => $collection->push("author_id = '{$data->author_id}'"))
                ->when($data->status, fn ($collection) => $collection->push("status = '{$data->status->value}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
