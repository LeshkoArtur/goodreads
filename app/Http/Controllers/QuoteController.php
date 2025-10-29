<?php

namespace App\Http\Controllers;

use App\Actions\Quotes\CreateQuote;
use App\Actions\Quotes\FavoriteQuote;
use App\Actions\Quotes\GetQuoteLikes;
use App\Actions\Quotes\GetQuotes;
use App\Actions\Quotes\LikeQuote;
use App\Actions\Quotes\UnfavoriteQuote;
use App\Actions\Quotes\UnlikeQuote;
use App\Actions\Quotes\UpdateQuote;
use App\Data\Quote\QuoteIndexData;
use App\Data\Quote\QuoteRelationIndexData;
use App\Data\Quote\QuoteStoreData;
use App\Data\Quote\QuoteUpdateData;
use App\Http\Requests\Quote\QuoteDeleteRequest;
use App\Http\Requests\Quote\QuoteIndexRequest;
use App\Http\Requests\Quote\QuoteRelationRequest;
use App\Http\Requests\Quote\QuoteStoreRequest;
use App\Http\Requests\Quote\QuoteUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\LikeResource;
use App\Http\Resources\QuoteResource;
use App\Http\Resources\UserResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuoteController extends Controller
{
    public function index(QuoteIndexRequest $request): AnonymousResourceCollection
    {
        $quotes = GetQuotes::run(QuoteIndexData::fromRequest($request));

        return QuoteResource::collection($quotes);
    }

    public function show(Quote $quote): QuoteResource
    {
        return new QuoteResource($quote->load(['user', 'book']));
    }

    public function store(QuoteStoreRequest $request): QuoteResource
    {
        $quote = CreateQuote::run(QuoteStoreData::fromRequest($request));

        return new QuoteResource($quote);
    }

    public function update(QuoteUpdateRequest $request, Quote $quote): QuoteResource
    {
        $quote = UpdateQuote::run($quote, QuoteUpdateData::fromRequest($request));

        return new QuoteResource($quote);
    }

    public function destroy(QuoteDeleteRequest $request, Quote $quote): JsonResponse
    {
        $quote->delete();

        return response()->json([
            'message' => 'Цитату успішно видалено.',
        ], 200);
    }

    public function user(Quote $quote): UserResource
    {
        return new UserResource($quote->user);
    }

    public function book(Quote $quote): BookResource
    {
        return new BookResource($quote->book);
    }

    public function likes(QuoteRelationRequest $request, Quote $quote): AnonymousResourceCollection
    {
        $likes = GetQuoteLikes::run($quote, QuoteRelationIndexData::fromRequest($request));

        return LikeResource::collection($likes);
    }

    public function like(Request $request, Quote $quote): JsonResponse
    {
        $success = LikeQuote::run($quote, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже вподобали цю цитату.',
            ], 409);
        }

        return response()->json([
            'message' => 'Цитату успішно вподобано.',
        ], 201);
    }

    public function unlike(Request $request, Quote $quote): JsonResponse
    {
        $success = UnlikeQuote::run($quote, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не вподобали цю цитату.',
            ], 404);
        }

        return response()->json([
            'message' => 'Вподобання успішно видалено.',
        ], 200);
    }

    public function favorite(Request $request, Quote $quote): JsonResponse
    {
        $success = FavoriteQuote::run($quote, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви вже додали цю цитату до улюблених.',
            ], 409);
        }

        return response()->json([
            'message' => 'Цитату успішно додано до улюблених.',
        ], 201);
    }

    public function unfavorite(Request $request, Quote $quote): JsonResponse
    {
        $success = UnfavoriteQuote::run($quote, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ця цитата не є у ваших улюблених.',
            ], 404);
        }

        return response()->json([
            'message' => 'Цитату успішно видалено з улюблених.',
        ], 200);
    }
}
