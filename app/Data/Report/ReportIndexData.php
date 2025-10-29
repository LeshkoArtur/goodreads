<?php

namespace App\Data\Report;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Illuminate\Http\Request;

readonly class ReportIndexData
{
    public function __construct(
        public ?string $user_id = null,
        public ?ReportType $type = null,
        public ?string $reportable_type = null,
        public ?string $reportable_id = null,
        public ?ReportStatus $status = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'] ?? null,
            type: isset($data['type']) ? ReportType::from($data['type']) : null,
            reportable_type: $data['reportable_type'] ?? null,
            reportable_id: $data['reportable_id'] ?? null,
            status: isset($data['status']) ? ReportStatus::from($data['status']) : null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
