<?php

namespace App\Data\Report;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Illuminate\Http\Request;

readonly class ReportUpdateData
{
    public function __construct(
        public ?string $user_id = null,
        public ?ReportType $type = null,
        public ?string $reportable_id = null,
        public ?string $reportable_type = null,
        public ?string $description = null,
        public ?ReportStatus $status = null,
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
            reportable_id: $data['reportable_id'] ?? null,
            reportable_type: $data['reportable_type'] ?? null,
            description: $data['description'] ?? null,
            status: isset($data['status']) ? ReportStatus::from($data['status']) : null,
        );
    }
}
