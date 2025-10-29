<?php

namespace App\Actions\Reports;

use App\Enums\ReportStatus;
use App\Models\Report;
use Lorisleiva\Actions\Concerns\AsAction;

class MarkReviewed
{
    use AsAction;

    public function handle(Report $report): Report
    {
        $report->status = ReportStatus::REVIEWED;
        $report->save();

        return $report->fresh(['user', 'reportable']);
    }
}
