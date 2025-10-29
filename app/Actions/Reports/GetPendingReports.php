<?php

namespace App\Actions\Reports;

use App\Enums\ReportStatus;
use App\Models\Report;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPendingReports
{
    use AsAction;

    public function handle(): Collection
    {
        return Report::where('status', ReportStatus::PENDING)
            ->with(['user', 'reportable'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
