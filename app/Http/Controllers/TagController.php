<?php

namespace App\Http\Controllers;

use App\Actions\Tags\AttachTag;
use App\Actions\Tags\BulkAttachTags;
use App\Actions\Tags\CreateTag;
use App\Actions\Tags\DetachTag;
use App\Actions\Tags\GetPopularTags;
use App\Actions\Tags\GetTagItems;
use App\Actions\Tags\GetTagPosts;
use App\Actions\Tags\GetTags;
use App\Actions\Tags\GetTagUsageCount;
use App\Actions\Tags\GetTrendingTags;
use App\Actions\Tags\UpdateTag;
use App\Data\Tag\TagIndexData;
use App\Data\Tag\TagRelationIndexData;
use App\Data\Tag\TagStoreData;
use App\Data\Tag\TagUpdateData;
use App\Http\Requests\Tag\TagAttachRequest;
use App\Http\Requests\Tag\TagBulkAttachRequest;
use App\Http\Requests\Tag\TagDeleteRequest;
use App\Http\Requests\Tag\TagDetachRequest;
use App\Http\Requests\Tag\TagIndexRequest;
use App\Http\Requests\Tag\TagRelationRequest;
use App\Http\Requests\Tag\TagStoreRequest;
use App\Http\Requests\Tag\TagUpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    public function index(TagIndexRequest $request): AnonymousResourceCollection
    {
        $tags = GetTags::run(TagIndexData::fromRequest($request));

        return TagResource::collection($tags);
    }

    public function show(Tag $tag): TagResource
    {
        return new TagResource($tag->load(['posts']));
    }

    public function store(TagStoreRequest $request): TagResource
    {
        $tag = CreateTag::run(TagStoreData::fromRequest($request));

        return new TagResource($tag);
    }

    public function update(TagUpdateRequest $request, Tag $tag): TagResource
    {
        $tag = UpdateTag::run($tag, TagUpdateData::fromRequest($request));

        return new TagResource($tag);
    }

    public function destroy(TagDeleteRequest $request, Tag $tag): JsonResponse
    {
        $tag->delete();

        return response()->json([
            'message' => 'Тег успішно видалено.',
        ], 200);
    }

    public function items(TagRelationRequest $request, Tag $tag): AnonymousResourceCollection
    {
        $items = GetTagItems::run($tag, TagRelationIndexData::fromRequest($request));

        return PostResource::collection($items);
    }

    public function books(TagRelationRequest $request, Tag $tag): AnonymousResourceCollection
    {
        return PostResource::collection([]);
    }

    public function posts(TagRelationRequest $request, Tag $tag): AnonymousResourceCollection
    {
        $posts = GetTagPosts::run($tag, TagRelationIndexData::fromRequest($request));

        return PostResource::collection($posts);
    }

    public function usageCount(Tag $tag): JsonResponse
    {
        $count = GetTagUsageCount::run($tag);

        return response()->json([
            'usage_count' => $count,
        ]);
    }

    public function popular(TagIndexRequest $request): AnonymousResourceCollection
    {
        $tags = GetPopularTags::run(TagIndexData::fromRequest($request));

        return TagResource::collection($tags);
    }

    public function trending(TagIndexRequest $request): AnonymousResourceCollection
    {
        $tags = GetTrendingTags::run(TagIndexData::fromRequest($request));

        return TagResource::collection($tags);
    }

    public function attach(TagAttachRequest $request, Tag $tag): JsonResponse
    {
        $taggableType = $request->validated('taggable_type');
        $taggableId = $request->validated('taggable_id');

        $taggable = $this->resolveTaggable($taggableType, $taggableId);

        if (! $taggable) {
            return response()->json([
                'message' => 'Об\'єкт не знайдено.',
            ], 404);
        }

        $success = AttachTag::run($tag, $taggable);

        if (! $success) {
            return response()->json([
                'message' => 'Тег вже прикріплено до цього об\'єкта.',
            ], 409);
        }

        return response()->json([
            'message' => 'Тег успішно прикріплено.',
        ], 201);
    }

    public function detach(TagDetachRequest $request, Tag $tag): JsonResponse
    {
        $taggableType = $request->validated('taggable_type');
        $taggableId = $request->validated('taggable_id');

        $taggable = $this->resolveTaggable($taggableType, $taggableId);

        if (! $taggable) {
            return response()->json([
                'message' => 'Об\'єкт не знайдено.',
            ], 404);
        }

        $success = DetachTag::run($tag, $taggable);

        if (! $success) {
            return response()->json([
                'message' => 'Тег не прикріплено до цього об\'єкта.',
            ], 404);
        }

        return response()->json([
            'message' => 'Тег успішно відкріплено.',
        ], 200);
    }

    public function bulkAttach(TagBulkAttachRequest $request): JsonResponse
    {
        $tagIds = $request->validated('tag_ids');
        $taggableType = $request->validated('taggable_type');
        $taggableId = $request->validated('taggable_id');

        $taggable = $this->resolveTaggable($taggableType, $taggableId);

        if (! $taggable) {
            return response()->json([
                'message' => 'Об\'єкт не знайдено.',
            ], 404);
        }

        $success = BulkAttachTags::run($tagIds, $taggable);

        if (! $success) {
            return response()->json([
                'message' => 'Не вдалося прикріпити теги.',
            ], 400);
        }

        return response()->json([
            'message' => 'Теги успішно прикріплено.',
        ], 201);
    }

    private function resolveTaggable(string $type, string $id)
    {
        return match ($type) {
            'post' => Post::find($id),
            default => null,
        };
    }
}
