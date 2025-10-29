<?php

namespace App\Data\Author;

use App\Enums\TypeOfWork;
use Illuminate\Http\Request;

readonly class AuthorIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $nationality = null,
        public ?string $min_birth_date = null,
        public ?string $max_birth_date = null,
        public ?string $min_death_date = null,
        public ?string $max_death_date = null,
        public ?TypeOfWork $type_of_work = null,
        /** @var array<string, string>|null */
        public ?array $social_media_links = null,
        /** @var array<int, string>|null */
        public ?array $user_ids = null,
        /** @var array<int, string>|null */
        public ?array $book_ids = null,
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
            nationality: $data['nationality'] ?? null,
            min_birth_date: $data['min_birth_date'] ?? null,
            max_birth_date: $data['max_birth_date'] ?? null,
            min_death_date: $data['min_death_date'] ?? null,
            max_death_date: $data['max_death_date'] ?? null,
            type_of_work: isset($data['type_of_work']) ? TypeOfWork::from($data['type_of_work']) : null,
            social_media_links: $data['social_media_links'] ?? null,
            user_ids: $data['user_ids'] ?? null,
            book_ids: $data['book_ids'] ?? null,
        );
    }
}
