<?php

namespace App\Actions\Users;

use App\DTOs\User\UserUpdateDTO;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUser
{
    use AsAction;

    /**
     * Оновити існуючого користувача.
     *
     * @param User $user
     * @param UserUpdateDTO $dto
     * @return User
     */
    public function handle(User $user, UserUpdateDTO $dto): User
    {
        $attributes = [
            'username' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
            'role' => $dto->role,
            'gender' => $dto->gender,
            'is_public' => $dto->isPublic,
            'location' => $dto->location,
            'social_media_links' => $dto->socialMediaLinks,
            'birthday' => $dto->birthday,
            'bio' => $dto->bio,
        ];

        $user->fill(array_filter($attributes, fn($value) => $value !== null));

        $user->save();

        return $user->load([
            'authors',
            'shelves',
            'books',
            'ratings',
            'quotes',
            'notes',
            'comments',
            'likes',
            'favorites',
            'following',
            'followers',
            'viewHistories',
            'groups',
            'groupInvitations',
            'eventRsvps'
        ]);
    }
}
