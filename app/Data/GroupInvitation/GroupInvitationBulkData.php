<?php

namespace App\Data\GroupInvitation;

use Illuminate\Http\Request;

readonly class GroupInvitationBulkData
{
    public function __construct(
        /** @var array<int, string> */
        public array $invitation_ids,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            invitation_ids: $data['invitation_ids'],
        );
    }
}
