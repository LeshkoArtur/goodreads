<?php

namespace App\Actions\Reports;

use App\Enums\ReportStatus;
use App\Models\Report;
use Lorisleiva\Actions\Concerns\AsAction;

class DismissReport
{
    use AsAction;

    public function handle(Report $report): Report
    {
        $report->status = ReportStatus::DISMISSED;
        $report->save();

        return $report->fresh(['user', 'reportable']);
    }
}
