<?php

namespace App\Actions\Reports;

use App\Enums\ReportType;
use App\Models\Report;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetReportsByType
{
    use AsAction;

    public function handle(ReportType $type): Collection
    {
        return Report::where('type', $type)
            ->with(['user', 'reportable'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
