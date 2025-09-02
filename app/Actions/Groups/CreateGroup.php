<?php

namespace App\Actions\Groups;

use App\DTOs\Group\GroupStoreDTO;
use App\Models\Group;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroup
{
    use AsAction;

    /**
     * Створити нову групу.
     *
     * @param GroupStoreDTO $dto
     * @return Group
     */
    public function handle(GroupStoreDTO $dto): Group
    {
        $group = new Group();
        $group->name = $dto->name;
        $group->description = $dto->description;
        $group->creator_id = $dto->creatorId;
        $group->is_public = $dto->isPublic;
        $group->rules = $dto->rules;
        $group->member_count = $dto->memberCount;
        $group->is_active = $dto->isActive;
        $group->join_policy = $dto->joinPolicy;
        $group->post_policy = $dto->postPolicy;

        if ($dto->coverImage) {
            $group->cover_image = $group->handleFileUpload($dto->coverImage, 'group_covers');
        }

        $group->save();

        return $group->load(['creator', 'members', 'posts', 'events', 'invitations', 'polls', 'moderationLogs']);
    }
}
