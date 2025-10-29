<?php

namespace App\Actions\Reports;

use App\Enums\ReportStatus;
use App\Models\Report;
use Lorisleiva\Actions\Concerns\AsAction;

class ResolveReport
{
    use AsAction;

    public function handle(Report $report): Report
    {
        $report->status = ReportStatus::RESOLVED;
        $report->save();

        return $report->fresh(['user', 'reportable']);
    }
}
