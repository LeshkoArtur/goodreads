<?php

namespace App\DTOs\Report;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use Illuminate\Http\Request;

class ReportStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param ReportType $type Тип репорту
     * @param string $reportableId ID об'єкта репорту
     * @param string $reportableType Тип об'єкта репорту
     * @param string|null $description Опис
     * @param ReportStatus|null $status Статус репорту
     */
    public function __construct(
        public readonly string $userId,
        public readonly ReportType $type,
        public readonly string $reportableId,
        public readonly string $reportableType,
        public readonly ?string $description = null,
        public readonly ?ReportStatus $status = null
    ) {}

    /**
     * Створити ReportStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            type: ReportType::from($request->input('type')),
            reportableId: $request->input('reportable_id'),
            reportableType: $request->input('reportable_type'),
            description: $request->input('description'),
            status: $request->input('status') ? ReportStatus::from($request->input('status')) : null
        );
    }
}
