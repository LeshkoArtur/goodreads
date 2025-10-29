<?php

namespace App\Data\Report;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Illuminate\Http\Request;

readonly class ReportStoreData
{
    public function __construct(
        public string $user_id,
        public ReportType $type,
        public string $reportable_id,
        public string $reportable_type,
        public string $description,
        public ?ReportStatus $status = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            type: ReportType::from($data['type']),
            reportable_id: $data['reportable_id'],
            reportable_type: $data['reportable_type'],
            description: $data['description'],
            status: isset($data['status']) ? ReportStatus::from($data['status']) : null,
        );
    }
}
