<?php

namespace App\Actions\Reports;

use App\Data\Report\ReportUpdateData;
use App\Models\Report;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateReport
{
    use AsAction;

    public function handle(Report $report, ReportUpdateData $data): Report
    {
        $report->update(array_filter([
            'user_id' => $data->user_id,
            'type' => $data->type,
            'reportable_id' => $data->reportable_id,
            'reportable_type' => $data->reportable_type,
            'description' => $data->description,
            'status' => $data->status,
        ], fn ($value) => $value !== null));

        return $report->fresh(['user', 'reportable']);
    }
}
