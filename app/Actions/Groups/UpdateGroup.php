<?php

namespace App\Actions\Groups;

use App\DTOs\Group\GroupUpdateDTO;
use App\Models\Group;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroup
{
    use AsAction;

    /**
     * Оновити існуючу групу.
     *
     * @param Group $group
     * @param GroupUpdateDTO $dto
     * @return Group
     */
    public function handle(Group $group, GroupUpdateDTO $dto): Group
    {
        $attributes = [
            'name' => $dto->name,
            'is_public' => $dto->isPublic,
            'is_active' => $dto->isActive,
            'join_policy' => $dto->joinPolicy,
            'post_policy' => $dto->postPolicy,
            'description' => $dto->description,
        ];

        $group->fill(array_filter($attributes, fn($value) => $value !== null));

        $group->save();

        return $group->load(['creator', 'members', 'posts', 'events', 'invitations', 'polls', 'moderationLogs']);
    }
}
