<?php

namespace App\Actions\Reports;

use App\DTOs\Report\ReportUpdateDTO;
use App\Models\Report;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateReport
{
    use AsAction;

    /**
     * Оновити існуючий звіт.
     *
     * @param Report $report
     * @param ReportUpdateDTO $dto
     * @return Report
     */
    public function handle(Report $report, ReportUpdateDTO $dto): Report
    {
        $attributes = [
            'type' => $dto->reason,
            'description' => $dto->description,
            'status' => $dto->status,
        ];

        $report->fill(array_filter($attributes, fn($value) => $value !== null));

        $report->save();

        return $report->load(['user', 'reportable']);
    }
}
