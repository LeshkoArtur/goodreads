<?php

namespace App\Data\GroupPoll;

use Illuminate\Http\Request;

readonly class GroupPollStoreData
{
    public function __construct(
        public string $group_id,
        public string $question,
        /** @var array<int, string> */
        public array $options,
        public ?bool $is_active = true,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            group_id: $data['group_id'],
            question: $data['question'],
            options: $data['options'],
            is_active: $data['is_active'] ?? true,
        );
    }
}
