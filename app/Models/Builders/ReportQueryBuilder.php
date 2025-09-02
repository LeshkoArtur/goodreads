<?php

namespace App\Models\Builders;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Illuminate\Database\Eloquent\Builder;

class ReportQueryBuilder extends Builder
{
    /**
     * Звіти від певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Звіти для певної сутності (reportable).
     */
    public function forReportable(string $type, string $id): static
    {
        return $this->where('reportable_type', $type)->where('reportable_id', $id);
    }

    /**
     * Звіти з певним типом.
     */
    public function withType(ReportType $type): static
    {
        return $this->where('type', $type);
    }

    /**
     * Звіти з певним статусом.
     */
    public function withStatus(ReportStatus $status): static
    {
        return $this->where('status', $status);
    }
}
