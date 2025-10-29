<?php

namespace App\Actions\Reports;

use App\Data\Report\ReportStoreData;
use App\Models\Report;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateReport
{
    use AsAction;

    public function handle(ReportStoreData $data): Report
    {
        $report = new Report;
        $report->user_id = $data->user_id;
        $report->type = $data->type;
        $report->reportable_id = $data->reportable_id;
        $report->reportable_type = $data->reportable_type;
        $report->description = $data->description;
        $report->status = $data->status;
        $report->save();

        return $report->fresh(['user', 'reportable']);
    }
}
