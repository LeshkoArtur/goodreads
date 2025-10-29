<?php

namespace App\Http\Controllers;

use App\Actions\Publishers\CreatePublisher;
use App\Actions\Publishers\GetPublisherBooks;
use App\Actions\Publishers\GetPublisherNewReleases;
use App\Actions\Publishers\GetPublisherPopularBooks;
use App\Actions\Publishers\GetPublishers;
use App\Actions\Publishers\GetPublisherStats;
use App\Actions\Publishers\UpdatePublisher;
use App\Data\Publisher\PublisherIndexData;
use App\Data\Publisher\PublisherRelationIndexData;
use App\Data\Publisher\PublisherStoreData;
use App\Data\Publisher\PublisherUpdateData;
use App\Http\Requests\Publisher\PublisherDeleteRequest;
use App\Http\Requests\Publisher\PublisherIndexRequest;
use App\Http\Requests\Publisher\PublisherRelationRequest;
use App\Http\Requests\Publisher\PublisherStoreRequest;
use App\Http\Requests\Publisher\PublisherUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PublisherController extends Controller
{
    public function index(PublisherIndexRequest $request): AnonymousResourceCollection
    {
        $publishers = GetPublishers::run(PublisherIndexData::fromRequest($request));

        return PublisherResource::collection($publishers);
    }

    public function show(Publisher $publisher): PublisherResource
    {
        return new PublisherResource($publisher->load(['books']));
    }

    public function store(PublisherStoreRequest $request): PublisherResource
    {
        $publisher = CreatePublisher::run(PublisherStoreData::fromRequest($request));

        return new PublisherResource($publisher);
    }

    public function update(PublisherUpdateRequest $request, Publisher $publisher): PublisherResource
    {
        $publisher = UpdatePublisher::run($publisher, PublisherUpdateData::fromRequest($request));

        return new PublisherResource($publisher);
    }

    public function destroy(PublisherDeleteRequest $request, Publisher $publisher): JsonResponse
    {
        $publisher->delete();

        return response()->json([
            'message' => 'Видавця успішно видалено.',
        ], 200);
    }

    public function books(PublisherRelationRequest $request, Publisher $publisher): AnonymousResourceCollection
    {
        $books = GetPublisherBooks::run($publisher, PublisherRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function popularBooks(PublisherRelationRequest $request, Publisher $publisher): AnonymousResourceCollection
    {
        $books = GetPublisherPopularBooks::run($publisher, PublisherRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function newReleases(PublisherRelationRequest $request, Publisher $publisher): AnonymousResourceCollection
    {
        $books = GetPublisherNewReleases::run($publisher, PublisherRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function stats(Publisher $publisher): JsonResponse
    {
        $stats = GetPublisherStats::run($publisher);

        return response()->json($stats);
    }
}
