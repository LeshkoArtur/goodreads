<?php

namespace App\Actions\ViewHistories;

use App\Data\ViewHistory\ViewHistoryUpdateData;
use App\Models\ViewHistory;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateViewHistory
{
    use AsAction;

    public function handle(ViewHistory $viewHistory, ViewHistoryUpdateData $data): ViewHistory
    {
        $viewHistory->update(array_filter([
            'user_id' => $data->user_id,
            'viewable_id' => $data->viewable_id,
            'viewable_type' => $data->viewable_type,
        ], fn ($value) => $value !== null));

        return $viewHistory->fresh(['user', 'viewable']);
    }
}
