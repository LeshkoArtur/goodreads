<?php

namespace App\Http\Controllers;

use App\Actions\Stores\CreateStore;
use App\Actions\Stores\GetStoreActiveOffers;
use App\Actions\Stores\GetStoreOffers;
use App\Actions\Stores\GetStores;
use App\Actions\Stores\GetStoreStats;
use App\Actions\Stores\UpdateStore;
use App\Data\Store\StoreIndexData;
use App\Data\Store\StoreRelationIndexData;
use App\Data\Store\StoreStoreData;
use App\Data\Store\StoreUpdateData;
use App\Http\Requests\Store\StoreDeleteRequest;
use App\Http\Requests\Store\StoreIndexRequest;
use App\Http\Requests\Store\StoreRelationRequest;
use App\Http\Requests\Store\StoreStoreRequest;
use App\Http\Requests\Store\StoreUpdateRequest;
use App\Http\Resources\BookOfferResource;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StoreController extends Controller
{
    public function index(StoreIndexRequest $request): AnonymousResourceCollection
    {
        $stores = GetStores::run(StoreIndexData::fromRequest($request));

        return StoreResource::collection($stores);
    }

    public function show(Store $store): StoreResource
    {
        return new StoreResource($store->load(['bookOffers']));
    }

    public function store(StoreStoreRequest $request): StoreResource
    {
        $store = CreateStore::run(StoreStoreData::fromRequest($request));

        return new StoreResource($store);
    }

    public function update(StoreUpdateRequest $request, Store $store): StoreResource
    {
        $store = UpdateStore::run($store, StoreUpdateData::fromRequest($request));

        return new StoreResource($store);
    }

    public function destroy(StoreDeleteRequest $request, Store $store): JsonResponse
    {
        $store->delete();

        return response()->json([
            'message' => 'Магазин успішно видалено.',
        ], 200);
    }

    public function offers(StoreRelationRequest $request, Store $store): AnonymousResourceCollection
    {
        $offers = GetStoreOffers::run($store, StoreRelationIndexData::fromRequest($request));

        return BookOfferResource::collection($offers);
    }

    public function activeOffers(StoreRelationRequest $request, Store $store): AnonymousResourceCollection
    {
        $offers = GetStoreActiveOffers::run($store, StoreRelationIndexData::fromRequest($request));

        return BookOfferResource::collection($offers);
    }

    public function stats(Store $store): JsonResponse
    {
        $stats = GetStoreStats::run($store);

        return response()->json($stats);
    }
}
