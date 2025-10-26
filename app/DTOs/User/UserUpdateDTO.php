<?php

namespace App\DTOs\User;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\Gender;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $username = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null,
        public readonly ?string $emailVerifiedAt = null,
        public readonly ?string $profilePicture = null,
        public readonly ?string $bio = null,
        public readonly ?bool $isPublic = null,
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
            username: $data['username'] ?? null,
            email: $data['email'] ?? null,
            password: $data['password'] ?? null,
            emailVerifiedAt: $data['email_verified_at'] ?? null,
            profilePicture: $data['profile_picture'] ?? null,
            bio: $data['bio'] ?? null,
            isPublic: isset($data['is_public']) ? (bool) $data['is_public'] : null,
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
