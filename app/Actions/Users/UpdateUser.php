<?php

namespace App\Actions\Users;

use App\Data\User\UserUpdateData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUser
{
    use AsAction;

    public function handle(User $user, UserUpdateData $data): User
    {
        $updateData = array_filter([
            'username' => $data->username,
            'email' => $data->email,
            'profile_picture' => $data->profile_picture,
            'bio' => $data->bio,
            'is_public' => $data->is_public,
            'birthday' => $data->birthday,
            'location' => $data->location,
            'social_media_links' => $data->social_media_links,
            'role' => $data->role,
            'gender' => $data->gender,
        ], fn ($value) => $value !== null);

        if ($data->password !== null) {
            $updateData['password'] = Hash::make($data->password);
        }

        $user->update($updateData);

        return $user->fresh(['authors', 'shelves']);
    }
}
