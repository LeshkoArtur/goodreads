<?php

namespace App\DTOs\PollVote;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PollVoteStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $groupPollId,
        public readonly string $pollOptionId,
        public readonly string $userId,
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
            groupPollId: $data['group_poll_id'],
            pollOptionId: $data['poll_option_id'],
            userId: $data['user_id'],
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
