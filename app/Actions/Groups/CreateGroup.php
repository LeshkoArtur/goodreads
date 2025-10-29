<?php

namespace App\Actions\Groups;

use App\Data\Group\GroupStoreData;
use App\Models\Group;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroup
{
    use AsAction;

    public function handle(GroupStoreData $data): Group
    {
        $group = new Group;
        $group->name = $data->name;
        $group->creator_id = $data->creator_id;
        $group->description = $data->description;
        $group->is_public = $data->is_public;
        $group->cover_image = $data->cover_image;
        $group->rules = $data->rules;
        $group->member_count = $data->member_count;
        $group->is_active = $data->is_active;
        $group->join_policy = $data->join_policy;
        $group->post_policy = $data->post_policy;
        $group->save();

        when($data->member_ids, fn () => $group->members()->sync($data->member_ids));

        return $group->fresh(['creator', 'members', 'posts']);
    }
}
