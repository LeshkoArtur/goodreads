<?php

namespace App\Actions\Users;

use App\DTOs\User\UserStoreDTO;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUser
{
    use AsAction;

    /**
     * Створити нового користувача.
     *
     * @param UserStoreDTO $dto
     * @return User
     */
    public function handle(UserStoreDTO $dto): User
    {
        $user = new User();
        $user->username = $dto->username;
        $user->email = $dto->email;
        $user->password = $dto->password;
        $user->email_verified_at = $dto->emailVerifiedAt;
        $user->bio = $dto->bio;
        $user->is_public = $dto->isPublic;
        $user->birthday = $dto->birthday;
        $user->location = $dto->location;
        $user->last_login = $dto->lastLogin;
        $user->social_media_links = $dto->socialMediaLinks;
        $user->role = $dto->role?->value;
        $user->gender = $dto->gender?->value;

        if ($dto->profilePicture) {
            $user->profile_picture = $user->handleFileUpload($dto->profilePicture, 'profile_pictures');
        }

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
