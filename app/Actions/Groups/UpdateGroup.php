<?php

namespace App\Actions\Groups;

use App\Data\Group\GroupUpdateData;
use App\Models\Group;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroup
{
    use AsAction;

    public function handle(Group $group, GroupUpdateData $data): Group
    {
        $group->update(array_filter([
            'name' => $data->name,
            'creator_id' => $data->creator_id,
            'description' => $data->description,
            'is_public' => $data->is_public,
            'cover_image' => $data->cover_image,
            'rules' => $data->rules,
            'member_count' => $data->member_count,
            'is_active' => $data->is_active,
            'join_policy' => $data->join_policy,
            'post_policy' => $data->post_policy,
        ], fn ($value) => $value !== null));

        when($data->member_ids !== null, fn () => $group->members()->sync($data->member_ids));

        return $group->fresh(['creator', 'members', 'posts']);
    }
}
