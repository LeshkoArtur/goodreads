<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:100'],
            'birthday' => ['nullable', 'date'],
            'profile_picture' => ['nullable', 'string', 'max:2048'],
        ])->validate();

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'username' => $input['username'],
                'email' => $input['email'],
                'bio' => $input['bio'] ?? $user->bio,
                'location' => $input['location'] ?? $user->location,
                'birthday' => $input['birthday'] ?? $user->birthday,
                'profile_picture' => $input['profile_picture'] ?? $user->profile_picture,
            ])->save();
        }
    }

    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'username' => $input['username'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'bio' => $input['bio'] ?? $user->bio,
            'location' => $input['location'] ?? $user->location,
            'birthday' => $input['birthday'] ?? $user->birthday,
            'profile_picture' => $input['profile_picture'] ?? $user->profile_picture,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
