<?php

namespace App\Actions\AuthorQuestions;

use App\Data\AuthorQuestion\AuthorQuestionIndexData;
use App\Models\AuthorQuestion;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthorQuestions
{
    use AsAction;

    public function handle(AuthorQuestionIndexData $data): LengthAwarePaginator
    {
        $searchQuery = AuthorQuestion::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        when(
            in_array($data->sort, ['created_at']),
            fn () => $searchQuery->orderBy($data->sort, $data->direction ?? 'desc')
        );

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/author-questions');

        return $paginator;
    }

    private function applyFilters(Builder $query, AuthorQuestionIndexData $data): void
    {
        $filters = collect()
            ->when($data->user_id, fn ($collection) => $collection->push("user_id = '{$data->user_id}'"))
            ->when($data->author_id, fn ($collection) => $collection->push("author_id = '{$data->author_id}'"))
            ->when($data->book_id, fn ($collection) => $collection->push("book_id = '{$data->book_id}'"))
            ->when($data->status, fn ($collection) => $collection->push("status = '{$data->status->value}'"));

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
