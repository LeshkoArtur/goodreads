<?php

namespace App\Http\Controllers;

use App\Actions\BookOffers\CreateBookOffer;
use App\Actions\BookOffers\GetBookOffers;
use App\Actions\BookOffers\UpdateBookOffer;
use App\Data\BookOffer\BookOfferIndexData;
use App\Data\BookOffer\BookOfferStoreData;
use App\Data\BookOffer\BookOfferUpdateData;
use App\Http\Requests\BookOffer\BookOfferDeleteRequest;
use App\Http\Requests\BookOffer\BookOfferIndexRequest;
use App\Http\Requests\BookOffer\BookOfferStoreRequest;
use App\Http\Requests\BookOffer\BookOfferUpdateRequest;
use App\Http\Resources\BookOfferResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\StoreResource;
use App\Models\BookOffer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookOfferController extends Controller
{
    public function index(BookOfferIndexRequest $request): AnonymousResourceCollection
    {
        $bookOffers = GetBookOffers::run(BookOfferIndexData::fromRequest($request));

        return BookOfferResource::collection($bookOffers);
    }

    public function show(BookOffer $bookOffer): BookOfferResource
    {
        return new BookOfferResource($bookOffer->load(['book', 'store']));
    }

    public function store(BookOfferStoreRequest $request): BookOfferResource
    {
        $bookOffer = CreateBookOffer::run(BookOfferStoreData::fromRequest($request));

        return new BookOfferResource($bookOffer);
    }

    public function update(BookOfferUpdateRequest $request, BookOffer $bookOffer): BookOfferResource
    {
        $bookOffer = UpdateBookOffer::run($bookOffer, BookOfferUpdateData::fromRequest($request));

        return new BookOfferResource($bookOffer);
    }

    public function destroy(BookOfferDeleteRequest $request, BookOffer $bookOffer): JsonResponse
    {
        $bookOffer->delete();

        return response()->json([
            'message' => 'Пропозицію книги успішно видалено.',
        ], 200);
    }

    public function book(BookOffer $bookOffer): BookResource
    {
        return new BookResource($bookOffer->book);
    }

    public function storeRelation(BookOffer $bookOffer): StoreResource
    {
        return new StoreResource($bookOffer->store);
    }
}
