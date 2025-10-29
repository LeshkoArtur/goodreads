<?php

namespace App\Http\Controllers;

use App\Actions\Favorites\CreateFavorite;
use App\Actions\Favorites\GetFavoriteAuthors;
use App\Actions\Favorites\GetFavoriteBooks;
use App\Actions\Favorites\GetFavoriteFavoriteable;
use App\Actions\Favorites\GetFavoritePosts;
use App\Actions\Favorites\GetFavoriteQuotes;
use App\Actions\Favorites\GetFavorites;
use App\Actions\Favorites\GetFavoriteUser;
use App\Actions\Favorites\ToggleFavorite;
use App\Data\Favorite\FavoriteIndexData;
use App\Data\Favorite\FavoriteStoreData;
use App\Data\Favorite\FavoriteToggleData;
use App\Data\Favorite\FavoriteTypeData;
use App\Http\Requests\Favorite\FavoriteDeleteRequest;
use App\Http\Requests\Favorite\FavoriteIndexRequest;
use App\Http\Requests\Favorite\FavoriteStoreRequest;
use App\Http\Requests\Favorite\FavoriteToggleRequest;
use App\Http\Requests\Favorite\FavoriteTypeRequest;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\UserResource;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteController extends Controller
{
    public function index(FavoriteIndexRequest $request): AnonymousResourceCollection
    {
        $favorites = GetFavorites::run(FavoriteIndexData::fromRequest($request));

        return FavoriteResource::collection($favorites);
    }

    public function show(Favorite $favorite): FavoriteResource
    {
        return new FavoriteResource($favorite->load(['user', 'favoriteable']));
    }

    public function store(FavoriteStoreRequest $request): FavoriteResource
    {
        $favorite = CreateFavorite::run(FavoriteStoreData::fromRequest($request), $request->user());

        return new FavoriteResource($favorite);
    }

    public function destroy(FavoriteDeleteRequest $request, Favorite $favorite): JsonResponse
    {
        $favorite->delete();

        return response()->json([
            'message' => 'Улюблене успішно видалено.',
        ], 200);
    }

    public function user(Favorite $favorite): UserResource
    {
        $user = GetFavoriteUser::run($favorite);

        return new UserResource($user);
    }

    public function favoriteable(Favorite $favorite): JsonResource
    {
        $favoriteable = GetFavoriteFavoriteable::run($favorite);

        if (! $favoriteable) {
            return response()->json([
                'message' => 'Об\'єкт улюбленого не знайдено.',
            ], 404);
        }

        return new JsonResource($favoriteable);
    }

    public function books(FavoriteTypeRequest $request): AnonymousResourceCollection
    {
        $favorites = GetFavoriteBooks::run($request->user(), FavoriteTypeData::fromRequest($request));

        return FavoriteResource::collection($favorites);
    }

    public function authors(FavoriteTypeRequest $request): AnonymousResourceCollection
    {
        $favorites = GetFavoriteAuthors::run($request->user(), FavoriteTypeData::fromRequest($request));

        return FavoriteResource::collection($favorites);
    }

    public function quotes(FavoriteTypeRequest $request): AnonymousResourceCollection
    {
        $favorites = GetFavoriteQuotes::run($request->user(), FavoriteTypeData::fromRequest($request));

        return FavoriteResource::collection($favorites);
    }

    public function posts(FavoriteTypeRequest $request): AnonymousResourceCollection
    {
        $favorites = GetFavoritePosts::run($request->user(), FavoriteTypeData::fromRequest($request));

        return FavoriteResource::collection($favorites);
    }

    public function toggle(FavoriteToggleRequest $request): JsonResponse
    {
        $result = ToggleFavorite::run(FavoriteToggleData::fromRequest($request), $request->user());

        $statusCode = $result['action'] === 'added' ? 201 : 200;

        return response()->json($result, $statusCode);
    }
}
