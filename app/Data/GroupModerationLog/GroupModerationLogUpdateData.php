<?php

namespace App\Data\GroupModerationLog;

use App\Enums\ModerationAction;
use Illuminate\Http\Request;

readonly class GroupModerationLogUpdateData
{
    public function __construct(
        public ?ModerationAction $action = null,
        public ?string $description = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            action: isset($data['action']) ? ModerationAction::from($data['action']) : null,
            description: $data['description'] ?? null,
        );
    }
}
