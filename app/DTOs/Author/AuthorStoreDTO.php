<?php

namespace App\DTOs\Author;

use App\DTOs\BaseDTO;
use App\Enums\TypeOfWork;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class AuthorStoreDTO extends BaseDTO
{
    public function __construct(
        public readonly string $name,
        public ?string $bio = null,
        public ?Carbon $birth_date = null,
        public ?string $birth_place = null,
        public ?string $nationality = null,
        public ?string $website = null,
        public ?string $profile_picture = null,
        public ?Carbon $death_date = null,
        public ?Collection $social_media_links = null,
        public ?Collection $media_images = null,
        public ?Collection $media_videos = null,
        public ?Collection $fun_facts = null,
        public ?TypeOfWork $type_of_work = null
    ) {}
}
