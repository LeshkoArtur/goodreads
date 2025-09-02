<?php

namespace App\Actions\GroupInvitations;

use App\DTOs\GroupInvitation\GroupInvitationIndexDTO;
use App\Models\GroupInvitation;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use MeiliSearch\Endpoints\Indexes;

class GetGroupInvitations
{
    use AsAction;

    /**
     * Отримати список запрошень до груп із пагінацією, фільтрацією та сортуванням через Meilisearch.
     *
     * @param GroupInvitationIndexDTO $dto
     * @return LengthAwarePaginator
     */
    public function handle(GroupInvitationIndexDTO $dto): LengthAwarePaginator
    {
        $searchQuery = GroupInvitation::search($dto->query ?? '');

        $this->applyFilters($searchQuery, $dto);

        if (in_array($dto->sort, ['created_at'])) {
            $searchQuery->orderBy($dto->sort, $dto->direction ?? 'desc');
        }

        return $searchQuery->paginate(
            perPage: $dto->perPage,
            page: $dto->page
        );
    }

    /**
     * Застосувати фільтри до пошукового запиту Meilisearch.
     *
     * @param Builder $query
     * @param GroupInvitationIndexDTO $dto
     * @return void
     */
    private function applyFilters(Builder $query, GroupInvitationIndexDTO $dto): void
    {
        $query->query(function (Indexes $meilisearch, $queryString, $options) use ($dto) {
            $options['filter'] = $options['filter'] ?? [];

            if ($dto->groupId) {
                $options['filter'][] = "group_id = '{$dto->groupId}'";
            }

            if ($dto->inviterId) {
                $options['filter'][] = "inviter_id = '{$dto->inviterId}'";
            }

            if ($dto->inviteeId) {
                $options['filter'][] = "invitee_id = '{$dto->inviteeId}'";
            }

            if ($dto->status) {
                $options['filter'][] = "status = '{$dto->status}'";
            }

            return $meilisearch->search($queryString, $options);
        });
    }
}
