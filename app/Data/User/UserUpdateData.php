<?php

namespace App\Data\User;

use App\Enums\Gender;
use App\Enums\Role;
use Illuminate\Http\Request;

readonly class UserUpdateData
{
    public function __construct(
        public ?string $username = null,
        public ?string $email = null,
        public ?string $password = null,
        public ?string $profile_picture = null,
        public ?string $bio = null,
        public ?bool $is_public = null,
        public ?string $birthday = null,
        public ?string $location = null,
        /** @var array<string, string>|null Example: ['twitter' => 'url', 'facebook' => 'url'] */
        public ?array $social_media_links = null,
        public ?Role $role = null,
        public ?Gender $gender = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            username: $data['username'] ?? null,
            email: $data['email'] ?? null,
            password: $data['password'] ?? null,
            profile_picture: $data['profile_picture'] ?? null,
            bio: $data['bio'] ?? null,
            is_public: $data['is_public'] ?? null,
            birthday: $data['birthday'] ?? null,
            location: $data['location'] ?? null,
            social_media_links: $data['social_media_links'] ?? null,
            role: isset($data['role']) ? Role::from($data['role']) : null,
            gender: isset($data['gender']) ? Gender::from($data['gender']) : null,
        );
    }
}
