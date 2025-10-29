<?php

namespace App\Http\Controllers;

use App\Actions\Comments\CreateComment;
use App\Actions\Comments\GetCommentLikes;
use App\Actions\Comments\GetCommentReplies;
use App\Actions\Comments\GetComments;
use App\Actions\Comments\GetCommentUser;
use App\Actions\Comments\LikeComment;
use App\Actions\Comments\ReplyToComment;
use App\Actions\Comments\UnlikeComment;
use App\Actions\Comments\UpdateComment;
use App\Data\Comment\CommentIndexData;
use App\Data\Comment\CommentRelationIndexData;
use App\Data\Comment\CommentReplyData;
use App\Data\Comment\CommentStoreData;
use App\Data\Comment\CommentUpdateData;
use App\Http\Requests\Comment\CommentDeleteRequest;
use App\Http\Requests\Comment\CommentIndexRequest;
use App\Http\Requests\Comment\CommentRelationRequest;
use App\Http\Requests\Comment\CommentReplyRequest;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LikeResource;
use App\Http\Resources\UserResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
    public function index(CommentIndexRequest $request): AnonymousResourceCollection
    {
        $comments = GetComments::run(CommentIndexData::fromRequest($request));

        return CommentResource::collection($comments);
    }

    public function show(Comment $comment): CommentResource
    {
        return new CommentResource($comment->load(['user', 'commentable', 'parent']));
    }

    public function store(CommentStoreRequest $request): CommentResource
    {
        $comment = CreateComment::run(CommentStoreData::fromRequest($request), $request->user());

        return new CommentResource($comment);
    }

    public function update(CommentUpdateRequest $request, Comment $comment): CommentResource
    {
        $comment = UpdateComment::run($comment, CommentUpdateData::fromRequest($request));

        return new CommentResource($comment);
    }

    public function destroy(CommentDeleteRequest $request, Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json([
            'message' => 'Коментар успішно видалено.',
        ], 200);
    }

    public function user(Comment $comment): UserResource
    {
        $user = GetCommentUser::run($comment);

        return new UserResource($user);
    }

    public function replies(CommentRelationRequest $request, Comment $comment): AnonymousResourceCollection
    {
        $replies = GetCommentReplies::run($comment, CommentRelationIndexData::fromRequest($request));

        return CommentResource::collection($replies);
    }

    public function likes(CommentRelationRequest $request, Comment $comment): AnonymousResourceCollection
    {
        $likes = GetCommentLikes::run($comment, CommentRelationIndexData::fromRequest($request));

        return LikeResource::collection($likes);
    }

    public function like(Request $request, Comment $comment): JsonResponse
    {
        $success = LikeComment::run($comment, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже вподобали цей коментар.',
            ], 409);
        }

        return response()->json([
            'message' => 'Коментар успішно вподобано.',
        ], 201);
    }

    public function unlike(Request $request, Comment $comment): JsonResponse
    {
        $success = UnlikeComment::run($comment, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не вподобали цей коментар.',
            ], 404);
        }

        return response()->json([
            'message' => 'Вподобання коментаря успішно видалено.',
        ], 200);
    }

    public function reply(CommentReplyRequest $request, Comment $comment): CommentResource
    {
        $reply = ReplyToComment::run($comment, CommentReplyData::fromRequest($request), $request->user());

        return new CommentResource($reply);
    }
}
