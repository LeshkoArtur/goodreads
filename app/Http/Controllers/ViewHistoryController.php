<?php

namespace App\Http\Controllers;

use App\Actions\ViewHistories\ClearHistory;
use App\Actions\ViewHistories\ClearHistoryByType;
use App\Actions\ViewHistories\CreateViewHistory;
use App\Actions\ViewHistories\GetMostViewed;
use App\Actions\ViewHistories\GetRecentViews;
use App\Actions\ViewHistories\GetViewHistories;
use App\Actions\ViewHistories\GetViewsByType;
use App\Data\ViewHistory\ViewHistoryIndexData;
use App\Data\ViewHistory\ViewHistoryStoreData;
use App\Http\Requests\ViewHistory\ViewHistoryDeleteRequest;
use App\Http\Requests\ViewHistory\ViewHistoryIndexRequest;
use App\Http\Requests\ViewHistory\ViewHistoryStoreRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\ViewHistoryResource;
use App\Models\ViewHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ViewHistoryController extends Controller
{
    public function index(ViewHistoryIndexRequest $request): AnonymousResourceCollection
    {
        $viewHistories = GetViewHistories::run(ViewHistoryIndexData::fromRequest($request));

        return ViewHistoryResource::collection($viewHistories);
    }

    public function show(ViewHistory $viewHistory): ViewHistoryResource
    {
        return new ViewHistoryResource($viewHistory->load(['user', 'viewable']));
    }

    public function store(ViewHistoryStoreRequest $request): ViewHistoryResource
    {
        $viewHistory = CreateViewHistory::run(ViewHistoryStoreData::fromRequest($request));

        return new ViewHistoryResource($viewHistory);
    }

    public function destroy(ViewHistoryDeleteRequest $request, ViewHistory $viewHistory): JsonResponse
    {
        $viewHistory->delete();

        return response()->json([
            'message' => 'Запис історії переглядів успішно видалено.',
        ], 200);
    }

    public function user(ViewHistory $viewHistory): UserResource
    {
        return new UserResource($viewHistory->user);
    }

    public function viewable(ViewHistory $viewHistory): JsonResponse
    {
        $viewable = $viewHistory->viewable;

        if (! $viewable) {
            return response()->json([
                'message' => 'Переглянутий об\'єкт не знайдено.',
            ], 404);
        }

        return response()->json([
            'id' => $viewable->id,
            'type' => class_basename($viewHistory->viewable_type),
            'data' => $viewable,
        ]);
    }

    public function books(): AnonymousResourceCollection
    {
        $views = GetViewsByType::run(auth()->user(), 'App\Models\Book');

        return ViewHistoryResource::collection($views);
    }

    public function authors(): AnonymousResourceCollection
    {
        $views = GetViewsByType::run(auth()->user(), 'App\Models\Author');

        return ViewHistoryResource::collection($views);
    }

    public function posts(): AnonymousResourceCollection
    {
        $views = GetViewsByType::run(auth()->user(), 'App\Models\Post');

        return ViewHistoryResource::collection($views);
    }

    public function recent(): AnonymousResourceCollection
    {
        $limit = request()->query('limit', 20);
        $views = GetRecentViews::run(auth()->user(), $limit);

        return ViewHistoryResource::collection($views);
    }

    public function mostViewed(): JsonResponse
    {
        $limit = request()->query('limit', 10);
        $mostViewed = GetMostViewed::run(auth()->user(), $limit);

        return response()->json([
            'most_viewed' => $mostViewed,
        ]);
    }

    public function clear(): JsonResponse
    {
        $deletedCount = ClearHistory::run(auth()->user());

        return response()->json([
            'message' => 'Історію переглядів успішно очищено.',
            'deleted_count' => $deletedCount,
        ], 200);
    }

    public function clearByType(string $type): JsonResponse
    {
        $typeMap = [
            'books' => 'App\Models\Book',
            'authors' => 'App\Models\Author',
            'posts' => 'App\Models\Post',
        ];

        $fullType = $typeMap[$type] ?? $type;
        $deletedCount = ClearHistoryByType::run(auth()->user(), $fullType);

        return response()->json([
            'message' => "Історію переглядів типу {$type} успішно очищено.",
            'deleted_count' => $deletedCount,
        ], 200);
    }
}
