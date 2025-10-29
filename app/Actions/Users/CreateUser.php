<?php

namespace App\Actions\Users;

use App\Data\User\UserStoreData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUser
{
    use AsAction;

    public function handle(UserStoreData $data): User
    {
        $user = new User;
        $user->username = $data->username;
        $user->email = $data->email;
        $user->password = Hash::make($data->password);
        $user->profile_picture = $data->profile_picture;
        $user->bio = $data->bio;
        $user->is_public = $data->is_public ?? true;
        $user->birthday = $data->birthday;
        $user->location = $data->location;
        $user->social_media_links = $data->social_media_links;
        $user->role = $data->role;
        $user->gender = $data->gender;
        $user->save();

        return $user->fresh(['authors', 'shelves']);
    }
}
