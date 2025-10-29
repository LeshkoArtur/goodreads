<?php

namespace App\Data\GroupModerationLog;

use App\Enums\ModerationAction;
use Illuminate\Http\Request;

readonly class GroupModerationLogStoreData
{
    public function __construct(
        public string $group_id,
        public ModerationAction $action,
        public string $targetable_type,
        public string $targetable_id,
        public ?string $description = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            group_id: $data['group_id'],
            action: ModerationAction::from($data['action']),
            targetable_type: $data['targetable_type'],
            targetable_id: $data['targetable_id'],
            description: $data['description'] ?? null,
        );
    }
}
