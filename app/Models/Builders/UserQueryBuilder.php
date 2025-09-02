<?php

namespace App\Models\Builders;

use App\Enums\Gender;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class UserQueryBuilder extends Builder
{
    /**
     * Користувачі з певною роллю.
     */
    public function withRole(Role $role): static
    {
        return $this->where('role', $role);
    }

    /**
     * Користувачі з певною статтю.
     */
    public function withGender(Gender $gender): static
    {
        return $this->where('gender', $gender);
    }

    /**
     * Публічні профілі користувачів.
     */
    public function isPublic(): static
    {
        return $this->where('is_public', true);
    }

    /**
     * Користувачі з підтвердженою електронною поштою.
     */
    public function emailVerified(): static
    {
        return $this->whereNotNull('email_verified_at');
    }

    /**
     * Користувачі, які востаннє заходили після певної дати.
     */
    public function lastLoginAfter(Carbon $date): static
    {
        return $this->where('last_login', '>', $date->toDateTimeString());
    }

    /**
     * Користувачі з певним ім’ям (частковий збіг).
     */
    public function withUsername(string $username): static
    {
        return $this->where('username', 'like', '%' . $username . '%');
    }

    /**
     * Користувачі, які стежать за певним автором.
     */
    public function followingAuthor(string $authorId): static
    {
        return $this->whereHas('authors', fn ($q) => $q->where('id', $authorId));
    }

    /**
     * Користувачі, які є учасниками певної групи.
     */
    public function inGroup(string $groupId): static
    {
        return $this->whereHas('groups', fn ($q) => $q->where('id', $groupId));
    }
}
