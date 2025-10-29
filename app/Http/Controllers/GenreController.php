<?php

namespace App\Http\Controllers;

use App\Actions\Genres\CreateGenre;
use App\Actions\Genres\GetGenreBooks;
use App\Actions\Genres\GetGenreNewReleases;
use App\Actions\Genres\GetGenrePopularBooks;
use App\Actions\Genres\GetGenres;
use App\Actions\Genres\GetGenreStats;
use App\Actions\Genres\GetGenreSubgenres;
use App\Actions\Genres\GetGenreTrendingBooks;
use App\Actions\Genres\UpdateGenre;
use App\Data\Genre\GenreIndexData;
use App\Data\Genre\GenreRelationIndexData;
use App\Data\Genre\GenreStoreData;
use App\Data\Genre\GenreUpdateData;
use App\Http\Requests\Genre\GenreDeleteRequest;
use App\Http\Requests\Genre\GenreIndexRequest;
use App\Http\Requests\Genre\GenreRelationRequest;
use App\Http\Requests\Genre\GenreStoreRequest;
use App\Http\Requests\Genre\GenreUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GenreController extends Controller
{
    public function index(GenreIndexRequest $request): AnonymousResourceCollection
    {
        $genres = GetGenres::run(GenreIndexData::fromRequest($request));

        return GenreResource::collection($genres);
    }

    public function show(Genre $genre): GenreResource
    {
        return new GenreResource($genre->load(['books', 'parent', 'children']));
    }

    public function store(GenreStoreRequest $request): GenreResource
    {
        $genre = CreateGenre::run(GenreStoreData::fromRequest($request));

        return new GenreResource($genre);
    }

    public function update(GenreUpdateRequest $request, Genre $genre): GenreResource
    {
        $genre = UpdateGenre::run($genre, GenreUpdateData::fromRequest($request));

        return new GenreResource($genre);
    }

    public function destroy(GenreDeleteRequest $request, Genre $genre): JsonResponse
    {
        $genre->delete();

        return response()->json([
            'message' => 'Жанр успішно видалено.',
        ], 200);
    }

    public function books(GenreRelationRequest $request, Genre $genre): AnonymousResourceCollection
    {
        $books = GetGenreBooks::run($genre, GenreRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function subgenres(GenreRelationRequest $request, Genre $genre): AnonymousResourceCollection
    {
        $subgenres = GetGenreSubgenres::run($genre, GenreRelationIndexData::fromRequest($request));

        return GenreResource::collection($subgenres);
    }

    public function parent(Genre $genre): ?GenreResource
    {
        if (! $genre->parent) {
            return null;
        }

        return new GenreResource($genre->parent);
    }

    public function popularBooks(GenreRelationRequest $request, Genre $genre): AnonymousResourceCollection
    {
        $books = GetGenrePopularBooks::run($genre, GenreRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function trendingBooks(GenreRelationRequest $request, Genre $genre): AnonymousResourceCollection
    {
        $books = GetGenreTrendingBooks::run($genre, GenreRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function newReleases(GenreRelationRequest $request, Genre $genre): AnonymousResourceCollection
    {
        $books = GetGenreNewReleases::run($genre, GenreRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function stats(Genre $genre): JsonResponse
    {
        $stats = GetGenreStats::run($genre);

        return response()->json($stats);
    }
}
