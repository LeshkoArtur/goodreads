<?php

namespace App\Data\GroupEvent;

use App\Enums\EventStatus;
use Illuminate\Http\Request;

readonly class GroupEventUpdateData
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $event_date = null,
        public ?string $location = null,
        public ?EventStatus $status = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
            event_date: $data['event_date'] ?? null,
            location: $data['location'] ?? null,
            status: isset($data['status']) ? EventStatus::from($data['status']) : null,
        );
    }
}
