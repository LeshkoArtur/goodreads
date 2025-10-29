<?php

namespace App\Actions\GroupInvitations;

use App\Data\GroupInvitation\GroupInvitationIndexData;
use App\Models\GroupInvitation;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupInvitations
{
    use AsAction;

    public function handle(GroupInvitationIndexData $data): LengthAwarePaginator
    {
        $searchQuery = GroupInvitation::search($data->q ?? '');

        $this->applyFilters($searchQuery, $data);

        if ($data->sort === 'created_at') {
            $searchQuery->orderBy($data->sort, $data->direction ?? 'desc');
        }

        $paginator = $searchQuery->paginate(
            perPage: $data->per_page ?? 15,
            page: $data->page ?? 1
        );

        $paginator->withPath(config('app.frontend_url').'/group-invitations');

        return $paginator;
    }

    private function applyFilters(Builder $query, GroupInvitationIndexData $data): void
    {
        $filters = collect()
                ->when($data->group_id, fn ($collection) => $collection->push("group_id = '{$data->group_id}'"))
                ->when($data->inviter_id, fn ($collection) => $collection->push("inviter_id = '{$data->inviter_id}'"))
                ->when($data->invitee_id, fn ($collection) => $collection->push("invitee_id = '{$data->invitee_id}'"))
                ->when($data->status, fn ($collection) => $collection->push("status = '{$data->status->value}'"))
                ;

        if ($filters->isNotEmpty()) {
            $query->options(['filter' => $filters->implode(' AND ')]);
        }
    }
}
