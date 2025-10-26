<?php

namespace App\DTOs\Author;

use App\DTOs\Traits\HandlesArrayInput;
use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку авторів.
 */
class AuthorIndexDTO
{
    use HandlesArrayInput;

    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $nationality = null,
        public readonly ?string $minBirthDate = null,
        public readonly ?string $maxBirthDate = null,
        public readonly ?string $minDeathDate = null,
        public readonly ?string $maxDeathDate = null,
        public readonly ?string $typeOfWork = null,
        public readonly ?array $socialMediaLinks = null,
        public readonly ?array $userIds = null,
        public readonly ?array $bookIds = null,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new static(
            query: $request->input('q'),
            page: (int) $request->input('page', 1),
            perPage: (int) $request->input('per_page', 15),
            sort: $request->input('sort', 'created_at'),
            direction: $request->input('direction', 'desc'),
            nationality: $request->input('nationality'),
            minBirthDate: $request->input('min_birth_date'),
            maxBirthDate: $request->input('max_birth_date'),
            minDeathDate: $request->input('min_death_date'),
            maxDeathDate: $request->input('max_death_date'),
            typeOfWork: $request->input('type_of_work'),
            socialMediaLinks: self::processArrayInput($request, 'social_media_links'),
            userIds: self::processArrayInput($request, 'user_ids'),
            bookIds: self::processArrayInput($request, 'book_ids'),
        );
    }
}
