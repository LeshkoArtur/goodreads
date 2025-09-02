<?php

namespace App\Actions\ViewHistories;

use App\DTOs\ViewHistory\ViewHistoryUpdateDTO;
use App\Models\ViewHistory;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateViewHistory
{
    use AsAction;

    /**
     * Оновити існуючий запис історії переглядів.
     *
     * @param ViewHistory $viewHistory
     * @param ViewHistoryUpdateDTO $dto
     * @return ViewHistory
     */
    public function handle(ViewHistory $viewHistory, ViewHistoryUpdateDTO $dto): ViewHistory
    {
        $attributes = [
            'viewable_type' => $dto->viewableType,
            'viewable_id' => $dto->viewableId,
        ];

        $viewHistory->fill(array_filter($attributes, fn($value) => $value !== null));

        if ($dto->viewedAt) {
            $viewHistory->created_at = $dto->viewedAt;
        }

        $viewHistory->save();

        return $viewHistory->load(['user', 'viewable']);
    }
}
