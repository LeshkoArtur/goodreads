<?php

namespace App\DTOs\User;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\Gender;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $username,
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $emailVerifiedAt = null,
        public readonly ?string $profilePicture = null,
        public readonly ?string $bio = null,
        public readonly bool $isPublic = false,
        public readonly ?string $birthday = null,
        public readonly ?string $location = null,
        public readonly ?string $lastLogin = null,
        public readonly ?Role $role = null,
        public readonly ?Gender $gender = null,
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
            username: $data['username'],
            email: $data['email'],
            password: $data['password'],
            emailVerifiedAt: $data['email_verified_at'] ?? null,
            profilePicture: $data['profile_picture'] ?? null,
            bio: $data['bio'] ?? null,
            isPublic: $data['is_public'] ?? false,
            birthday: $data['birthday'] ?? null,
            location: $data['location'] ?? null,
            lastLogin: $data['last_login'] ?? null,
            role: !empty($data['role']) ? Role::from($data['role']) : null,
            gender: !empty($data['gender']) ? Gender::from($data['gender']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
