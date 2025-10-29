<?php

namespace App\Http\Controllers;

use App\Actions\Posts\CreatePost;
use App\Actions\Posts\FavoritePost;
use App\Actions\Posts\GetPostComments;
use App\Actions\Posts\GetPostLikes;
use App\Actions\Posts\GetPosts;
use App\Actions\Posts\LikePost;
use App\Actions\Posts\UnfavoritePost;
use App\Actions\Posts\UnlikePost;
use App\Actions\Posts\UpdatePost;
use App\Data\Post\PostIndexData;
use App\Data\Post\PostRelationIndexData;
use App\Data\Post\PostStoreData;
use App\Data\Post\PostUpdateData;
use App\Http\Requests\Post\PostDeleteRequest;
use App\Http\Requests\Post\PostIndexRequest;
use App\Http\Requests\Post\PostRelationRequest;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LikeResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(PostIndexRequest $request): AnonymousResourceCollection
    {
        $posts = GetPosts::run(PostIndexData::fromRequest($request));

        return PostResource::collection($posts);
    }

    public function show(Post $post): PostResource
    {
        return new PostResource($post->load(['user', 'book', 'author', 'tags']));
    }

    public function store(PostStoreRequest $request): PostResource
    {
        $post = CreatePost::run(PostStoreData::fromRequest($request));

        return new PostResource($post);
    }

    public function update(PostUpdateRequest $request, Post $post): PostResource
    {
        $post = UpdatePost::run($post, PostUpdateData::fromRequest($request));

        return new PostResource($post);
    }

    public function destroy(PostDeleteRequest $request, Post $post): JsonResponse
    {
        $post->delete();

        return response()->json([
            'message' => 'Пост успішно видалено.',
        ], 200);
    }

    public function comments(PostRelationRequest $request, Post $post): AnonymousResourceCollection
    {
        $comments = GetPostComments::run($post, PostRelationIndexData::fromRequest($request));

        return CommentResource::collection($comments);
    }

    public function likes(PostRelationRequest $request, Post $post): AnonymousResourceCollection
    {
        $likes = GetPostLikes::run($post, PostRelationIndexData::fromRequest($request));

        return LikeResource::collection($likes);
    }

    public function user(Post $post): UserResource
    {
        return new UserResource($post->user);
    }

    public function book(Post $post): ?BookResource
    {
        if (! $post->book) {
            return null;
        }

        return new BookResource($post->book);
    }

    public function author(Post $post): ?AuthorResource
    {
        if (! $post->author) {
            return null;
        }

        return new AuthorResource($post->author);
    }

    public function like(Request $request, Post $post): JsonResponse
    {
        $success = LikePost::run($post, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже вподобали цей пост.',
            ], 409);
        }

        return response()->json([
            'message' => 'Пост успішно вподобано.',
        ], 201);
    }

    public function unlike(Request $request, Post $post): JsonResponse
    {
        $success = UnlikePost::run($post, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не вподобали цей пост.',
            ], 404);
        }

        return response()->json([
            'message' => 'Вподобання успішно видалено.',
        ], 200);
    }

    public function favorite(Request $request, Post $post): JsonResponse
    {
        $success = FavoritePost::run($post, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже додали цей пост до улюблених.',
            ], 409);
        }

        return response()->json([
            'message' => 'Пост успішно додано до улюблених.',
        ], 201);
    }

    public function unfavorite(Request $request, Post $post): JsonResponse
    {
        $success = UnfavoritePost::run($post, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Цей пост не є у ваших улюблених.',
            ], 404);
        }

        return response()->json([
            'message' => 'Пост успішно видалено з улюблених.',
        ], 200);
    }
}
