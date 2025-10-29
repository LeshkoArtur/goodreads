<?php

namespace App\Data\PollOption;

use Illuminate\Http\Request;

readonly class PollOptionUpdateData
{
    public function __construct(
        public string $text,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            text: $data['text'],
        );
    }
}
