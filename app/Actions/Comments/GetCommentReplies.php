<?php

namespace App\Actions\Comments;

use App\Data\Comment\CommentRelationIndexData;
use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCommentReplies
{
    use AsAction;

    public function handle(Comment $comment, CommentRelationIndexData $data): LengthAwarePaginator
    {
        return $comment->replies()
            ->with(['user'])
            ->withCount(['replies', 'likes'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
