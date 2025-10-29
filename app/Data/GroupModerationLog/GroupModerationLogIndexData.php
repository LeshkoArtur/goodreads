<?php

namespace App\Data\GroupModerationLog;

use App\Enums\ModerationAction;
use Illuminate\Http\Request;

readonly class GroupModerationLogIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $group_id = null,
        public ?string $moderator_id = null,
        public ?ModerationAction $action = null,
        public ?string $targetable_type = null,
        public ?string $targetable_id = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            q: $data['q'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
            group_id: $data['group_id'] ?? null,
            moderator_id: $data['moderator_id'] ?? null,
            action: isset($data['action']) ? ModerationAction::from($data['action']) : null,
            targetable_type: $data['targetable_type'] ?? null,
            targetable_id: $data['targetable_id'] ?? null,
        );
    }
}
