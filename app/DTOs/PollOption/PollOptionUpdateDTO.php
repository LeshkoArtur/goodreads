<?php

namespace App\DTOs\PollOption;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PollOptionUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $groupPollId = null,
        public readonly ?string $text = null,
        public readonly ?int $voteCount = null,
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
            groupPollId: $data['group_poll_id'] ?? null,
            text: $data['text'] ?? null,
            voteCount: isset($data['vote_count']) ? (int) $data['vote_count'] : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
