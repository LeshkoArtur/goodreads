<?php

namespace App\Data\PollOption;

use Illuminate\Http\Request;

readonly class PollOptionStoreData
{
    public function __construct(
        public string $group_poll_id,
        public string $text,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            group_poll_id: $data['group_poll_id'],
            text: $data['text'],
        );
    }
}
