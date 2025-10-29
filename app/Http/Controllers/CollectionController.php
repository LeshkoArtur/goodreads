<?php

namespace App\Http\Controllers;

use App\Actions\Collections\AddBookToCollection;
use App\Actions\Collections\CreateCollection;
use App\Actions\Collections\FollowCollection;
use App\Actions\Collections\GetCollectionBooks;
use App\Actions\Collections\GetCollectionPosts;
use App\Actions\Collections\GetCollections;
use App\Actions\Collections\GetCollectionStats;
use App\Actions\Collections\RemoveBookFromCollection;
use App\Actions\Collections\UnfollowCollection;
use App\Actions\Collections\UpdateCollection;
use App\Data\Collection\CollectionIndexData;
use App\Data\Collection\CollectionRelationIndexData;
use App\Data\Collection\CollectionStoreData;
use App\Data\Collection\CollectionUpdateData;
use App\Http\Requests\Collection\CollectionDeleteRequest;
use App\Http\Requests\Collection\CollectionIndexRequest;
use App\Http\Requests\Collection\CollectionRelationRequest;
use App\Http\Requests\Collection\CollectionStoreRequest;
use App\Http\Requests\Collection\CollectionUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Book;
use App\Models\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CollectionController extends Controller
{
    public function index(CollectionIndexRequest $request): AnonymousResourceCollection
    {
        $collections = GetCollections::run(CollectionIndexData::fromRequest($request));

        return CollectionResource::collection($collections);
    }

    public function show(Collection $collection): CollectionResource
    {
        return new CollectionResource($collection->load(['user', 'books']));
    }

    public function store(CollectionStoreRequest $request): CollectionResource
    {
        $collection = CreateCollection::run(CollectionStoreData::fromRequest($request));

        return new CollectionResource($collection);
    }

    public function update(CollectionUpdateRequest $request, Collection $collection): CollectionResource
    {
        $collection = UpdateCollection::run($collection, CollectionUpdateData::fromRequest($request));

        return new CollectionResource($collection);
    }

    public function destroy(CollectionDeleteRequest $request, Collection $collection): JsonResponse
    {
        $collection->delete();

        return response()->json([
            'message' => 'Колекцію успішно видалено.',
        ], 200);
    }

    public function books(CollectionRelationRequest $request, Collection $collection): AnonymousResourceCollection
    {
        $books = GetCollectionBooks::run($collection, CollectionRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function user(Collection $collection): UserResource
    {
        return new UserResource($collection->user);
    }

    public function posts(CollectionRelationRequest $request, Collection $collection): AnonymousResourceCollection
    {
        $posts = GetCollectionPosts::run($collection, CollectionRelationIndexData::fromRequest($request));

        return PostResource::collection($posts);
    }

    public function stats(Collection $collection): JsonResponse
    {
        $stats = GetCollectionStats::run($collection);

        return response()->json($stats);
    }

    public function addBook(Request $request, Collection $collection, Book $book): JsonResponse
    {
        $orderIndex = $request->input('order_index');

        $success = AddBookToCollection::run($collection, $book, $orderIndex);

        if (! $success) {
            return response()->json([
                'message' => 'Книга вже є в цій колекції.',
            ], 409);
        }

        return response()->json([
            'message' => 'Книгу успішно додано до колекції.',
        ], 201);
    }

    public function removeBook(Request $request, Collection $collection, Book $book): JsonResponse
    {
        $success = RemoveBookFromCollection::run($collection, $book);

        if (! $success) {
            return response()->json([
                'message' => 'Книга не знайдена в цій колекції.',
            ], 404);
        }

        return response()->json([
            'message' => 'Книгу успішно видалено з колекції.',
        ], 200);
    }

    public function follow(Request $request, Collection $collection): JsonResponse
    {
        $success = FollowCollection::run($collection, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже стежите за цією колекцією.',
            ], 409);
        }

        return response()->json([
            'message' => 'Ви тепер стежите за колекцією.',
        ], 201);
    }

    public function unfollow(Request $request, Collection $collection): JsonResponse
    {
        $success = UnfollowCollection::run($collection, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не стежите за цією колекцією.',
            ], 404);
        }

        return response()->json([
            'message' => 'Ви більше не стежите за колекцією.',
        ], 200);
    }
}
