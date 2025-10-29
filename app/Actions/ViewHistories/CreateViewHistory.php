<?php

namespace App\Actions\ViewHistories;

use App\Data\ViewHistory\ViewHistoryStoreData;
use App\Models\ViewHistory;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateViewHistory
{
    use AsAction;

    public function handle(ViewHistoryStoreData $data): ViewHistory
    {
        $viewHistory = new ViewHistory;
        $viewHistory->user_id = $data->user_id;
        $viewHistory->viewable_id = $data->viewable_id;
        $viewHistory->viewable_type = $data->viewable_type;
        $viewHistory->save();

        return $viewHistory->fresh(['user', 'viewable']);
    }
}
