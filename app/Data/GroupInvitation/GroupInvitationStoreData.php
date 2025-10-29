<?php

namespace App\Data\GroupInvitation;

use Illuminate\Http\Request;

readonly class GroupInvitationStoreData
{
    public function __construct(
        public string $group_id,
        public string $invitee_id,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            group_id: $data['group_id'],
            invitee_id: $data['invitee_id'],
        );
    }
}
