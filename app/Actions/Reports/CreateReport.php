<?php

namespace App\Actions\Reports;

use App\DTOs\Report\ReportStoreDTO;
use App\Models\Report;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateReport
{
    use AsAction;

    /**
     * Створити новий звіт.
     *
     * @param ReportStoreDTO $dto
     * @return Report
     */
    public function handle(ReportStoreDTO $dto): Report
    {
        $report = new Report();
        $report->user_id = $dto->userId;
        $report->type = $dto->type->value;
        $report->reportable_id = $dto->reportableId;
        $report->reportable_type = $dto->reportableType;
        $report->description = $dto->description;
        $report->status = $dto->status?->value;

        $report->save();

        return $report->load(['user', 'reportable']);
    }
}
