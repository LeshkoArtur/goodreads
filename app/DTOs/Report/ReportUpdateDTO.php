<?php

namespace App\DTOs\Report;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ReportUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $userId = null,
        public readonly ?ReportType $type = null,
        public readonly ?string $reportableId = null,
        public readonly ?string $reportableType = null,
        public readonly ?string $description = null,
        public readonly ?ReportStatus $status = null,
        public readonly array|Collection|null $mediaImages = null,
        public readonly array|Collection|null $socialMediaLinks = null
    ) {}

    public static function fromRequest(Request $request): static
    {
        return self::makeDTO($request->all());
    }

    public static function fromArray(array $data): static
    {
        return self::makeDTO($data);
    }

    private static function makeDTO(array $data): static
    {
        return new static(
            userId: $data['user_id'] ?? null,
            type: !empty($data['type']) ? ReportType::from($data['type']) : null,
            reportableId: $data['reportable_id'] ?? null,
            reportableType: $data['reportable_type'] ?? null,
            description: $data['description'] ?? null,
            status: !empty($data['status']) ? ReportStatus::from($data['status']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
