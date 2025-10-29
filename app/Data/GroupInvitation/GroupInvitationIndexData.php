<?php

namespace App\Data\GroupInvitation;

use App\Enums\InvitationStatus;
use Illuminate\Http\Request;

readonly class GroupInvitationIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $group_id = null,
        public ?string $inviter_id = null,
        public ?string $invitee_id = null,
        public ?InvitationStatus $status = null,
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
            inviter_id: $data['inviter_id'] ?? null,
            invitee_id: $data['invitee_id'] ?? null,
            status: isset($data['status']) ? InvitationStatus::from($data['status']) : null,
        );
    }
}
