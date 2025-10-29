<?php

namespace App\Http\Controllers;

use App\Actions\BookSeries\CreateBookSeries;
use App\Actions\BookSeries\GetBookSeries;
use App\Actions\BookSeries\GetBookSeriesAuthor;
use App\Actions\BookSeries\GetBookSeriesBooks;
use App\Actions\BookSeries\GetBookSeriesStats;
use App\Actions\BookSeries\UpdateBookSeries;
use App\Data\BookSeries\BookSeriesIndexData;
use App\Data\BookSeries\BookSeriesRelationIndexData;
use App\Data\BookSeries\BookSeriesStoreData;
use App\Data\BookSeries\BookSeriesUpdateData;
use App\Http\Requests\BookSeries\BookSeriesDeleteRequest;
use App\Http\Requests\BookSeries\BookSeriesIndexRequest;
use App\Http\Requests\BookSeries\BookSeriesRelationRequest;
use App\Http\Requests\BookSeries\BookSeriesStoreRequest;
use App\Http\Requests\BookSeries\BookSeriesUpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookSeriesResource;
use App\Models\BookSeries;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookSeriesController extends Controller
{
    public function index(BookSeriesIndexRequest $request): AnonymousResourceCollection
    {
        $bookSeries = GetBookSeries::run(BookSeriesIndexData::fromRequest($request));

        return BookSeriesResource::collection($bookSeries);
    }

    public function show(BookSeries $bookSeries): BookSeriesResource
    {
        return new BookSeriesResource($bookSeries->load(['books']));
    }

    public function store(BookSeriesStoreRequest $request): BookSeriesResource
    {
        $bookSeries = CreateBookSeries::run(BookSeriesStoreData::fromRequest($request));

        return new BookSeriesResource($bookSeries);
    }

    public function update(BookSeriesUpdateRequest $request, BookSeries $bookSeries): BookSeriesResource
    {
        $bookSeries = UpdateBookSeries::run($bookSeries, BookSeriesUpdateData::fromRequest($request));

        return new BookSeriesResource($bookSeries);
    }

    public function destroy(BookSeriesDeleteRequest $request, BookSeries $bookSeries): JsonResponse
    {
        $bookSeries->delete();

        return response()->json([
            'message' => 'Серію книг успішно видалено.',
        ], 200);
    }

    public function books(BookSeriesRelationRequest $request, BookSeries $bookSeries): AnonymousResourceCollection
    {
        $books = GetBookSeriesBooks::run($bookSeries, BookSeriesRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function author(BookSeries $bookSeries): ?AuthorResource
    {
        $author = GetBookSeriesAuthor::run($bookSeries);

        if (! $author) {
            return null;
        }

        return new AuthorResource($author);
    }

    public function stats(BookSeries $bookSeries): JsonResponse
    {
        $stats = GetBookSeriesStats::run($bookSeries);

        return response()->json($stats);
    }
}
