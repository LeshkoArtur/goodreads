<?php

namespace App\Actions\ViewHistories;

use App\DTOs\ViewHistory\ViewHistoryStoreDTO;
use App\Models\ViewHistory;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateViewHistory
{
    use AsAction;

    /**
     * Створити новий запис історії переглядів.
     *
     * @param ViewHistoryStoreDTO $dto
     * @return ViewHistory
     */
    public function handle(ViewHistoryStoreDTO $dto): ViewHistory
    {
        $viewHistory = new ViewHistory();
        $viewHistory->user_id = $dto->userId;
        $viewHistory->viewable_id = $dto->viewableId;
        $viewHistory->viewable_type = $dto->viewableType;

        $viewHistory->save();

        return $viewHistory->load(['user', 'viewable']);
    }
}
