<?php

namespace App\DTOs\Post;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\PostType;
use App\Enums\PostStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PostUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $userId = null,
        public readonly ?string $title = null,
        public readonly ?string $content = null,
        public readonly ?string $bookId = null,
        public readonly ?string $authorId = null,
        public readonly ?string $coverImage = null,
        public readonly ?string $publishedAt = null,
        public readonly ?array $tagIds = null,
        public readonly ?PostType $type = null,
        public readonly ?PostStatus $status = null,
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
            userId: $data['user_id'] ?? null,
            title: $data['title'] ?? null,
            content: $data['content'] ?? null,
            bookId: $data['book_id'] ?? null,
            authorId: $data['author_id'] ?? null,
            coverImage: $data['cover_image'] ?? null,
            publishedAt: $data['published_at'] ?? null,
            tagIds: self::processJsonArray($data['tag_ids'] ?? null),
            type: !empty($data['type']) ? PostType::from($data['type']) : null,
            status: !empty($data['status']) ? PostStatus::from($data['status']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
