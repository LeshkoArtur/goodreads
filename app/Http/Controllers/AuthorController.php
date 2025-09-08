<?php

namespace App\Http\Controllers;

use App\Actions\Authors\CreateAuthor;
use App\Actions\Authors\GetAuthors;
use App\Actions\Authors\UpdateAuthor;
use App\DTOs\Author\AuthorStoreDTO;
use App\DTOs\Author\AuthorUpdateDTO;
use App\DTOs\Authors\AuthorIndexDTO;
use App\Http\Requests\Author\AuthorDeleteRequest;
use App\Http\Requests\Author\AuthorIndexRequest;
use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    /**
     * Список авторів.
     */
    public function index(AuthorIndexRequest $request): AnonymousResourceCollection
    {
        $authorIndexDTO = AuthorIndexDTO::fromRequest($request);
        $authors = GetAuthors::run($authorIndexDTO);

        return AuthorResource::collection($authors);
    }

    /**
     * Показ одного автора.
     */
    public function show(Author $author): AuthorResource
    {
        return new AuthorResource($author->load(['users', 'books']));
    }

    /**
     * Створення нового автора.
     */
    public function store(AuthorStoreRequest $request): AuthorResource
    {
        $dto = AuthorStoreDTO::fromRequest($request);

        $author = CreateAuthor::run($dto);

        return new AuthorResource($author);
    }

    /**
     * Оновлення автора.
     */
    public function update(AuthorUpdateRequest $request, Author $author): AuthorResource
    {
        $dto = AuthorUpdateDTO::fromRequest($request);

        $author = UpdateAuthor::run($author, $dto);

        return new AuthorResource($author);
    }

    /**
     * Видалення автора.
     */
    public function destroy(AuthorDeleteRequest $request, Author $author): JsonResponse
    {
        $author->delete();

        return response()->json([
            'message' => __('Author deleted successfully.')
        ], 200);
    }
}
