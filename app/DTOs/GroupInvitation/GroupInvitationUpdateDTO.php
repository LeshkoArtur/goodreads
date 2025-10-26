<?php

namespace App\DTOs\GroupInvitation;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\InvitationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GroupInvitationUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $groupId = null,
        public readonly ?string $inviterId = null,
        public readonly ?string $inviteeId = null,
        public readonly ?InvitationStatus $status = null,
        public readonly array|Collection|null $mediaImages = null,
        public readonly array|Collection|null $socialMediaLinks = null
    ) {}

    public static function fromRequest(Request $request): static
    {
        return self::makeDTO($request->all());
    }

    public static function fromArray(array $data): static
    {
        return self::makeDTO($data);
    }

    private static function makeDTO(array $data): static
    {
        return new static(
            groupId: $data['group_id'] ?? null,
            inviterId: $data['inviter_id'] ?? null,
            inviteeId: $data['invitee_id'] ?? null,
            status: !empty($data['status']) ? InvitationStatus::from($data['status']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
