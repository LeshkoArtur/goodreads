<?php

namespace App\Http\Controllers;

use App\Actions\Shelves\AddBookToShelf;
use App\Actions\Shelves\BulkAddBooksToShelf;
use App\Actions\Shelves\BulkRemoveBooksFromShelf;
use App\Actions\Shelves\CreateShelf;
use App\Actions\Shelves\GetShelfBooks;
use App\Actions\Shelves\GetShelfStats;
use App\Actions\Shelves\GetShelves;
use App\Actions\Shelves\RemoveBookFromShelf;
use App\Actions\Shelves\UpdateShelf;
use App\Data\Shelf\ShelfIndexData;
use App\Data\Shelf\ShelfRelationIndexData;
use App\Data\Shelf\ShelfStoreData;
use App\Data\Shelf\ShelfUpdateData;
use App\Http\Requests\Shelf\ShelfDeleteRequest;
use App\Http\Requests\Shelf\ShelfIndexRequest;
use App\Http\Requests\Shelf\ShelfRelationRequest;
use App\Http\Requests\Shelf\ShelfStoreRequest;
use App\Http\Requests\Shelf\ShelfUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\ShelfResource;
use App\Http\Resources\UserResource;
use App\Models\Book;
use App\Models\Shelf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ShelfController extends Controller
{
    public function index(ShelfIndexRequest $request): AnonymousResourceCollection
    {
        $shelves = GetShelves::run(ShelfIndexData::fromRequest($request));

        return ShelfResource::collection($shelves);
    }

    public function show(Shelf $shelf): ShelfResource
    {
        return new ShelfResource($shelf->load(['user', 'books']));
    }

    public function store(ShelfStoreRequest $request): ShelfResource
    {
        $shelf = CreateShelf::run(ShelfStoreData::fromRequest($request));

        return new ShelfResource($shelf);
    }

    public function update(ShelfUpdateRequest $request, Shelf $shelf): ShelfResource
    {
        $shelf = UpdateShelf::run($shelf, ShelfUpdateData::fromRequest($request));

        return new ShelfResource($shelf);
    }

    public function destroy(ShelfDeleteRequest $request, Shelf $shelf): JsonResponse
    {
        $shelf->delete();

        return response()->json([
            'message' => 'Полицю успішно видалено.',
        ], 200);
    }

    public function books(ShelfRelationRequest $request, Shelf $shelf): AnonymousResourceCollection
    {
        $books = GetShelfBooks::run($shelf, ShelfRelationIndexData::fromRequest($request));

        return BookResource::collection($books);
    }

    public function user(Shelf $shelf): UserResource
    {
        return new UserResource($shelf->user);
    }

    public function addBook(Request $request, Shelf $shelf, Book $book): JsonResponse
    {
        $userBook = AddBookToShelf::run($shelf, $book, $request->user());

        return response()->json([
            'message' => 'Книгу успішно додано до полиці.',
            'user_book_id' => $userBook->id,
        ], 201);
    }

    public function removeBook(Request $request, Shelf $shelf, Book $book): JsonResponse
    {
        $success = RemoveBookFromShelf::run($shelf, $book, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Книга не знайдена на цій полиці.',
            ], 404);
        }

        return response()->json([
            'message' => 'Книгу успішно видалено з полиці.',
        ], 200);
    }

    public function bulkAddBooks(Request $request, Shelf $shelf): JsonResponse
    {
        $request->validate([
            'book_ids' => ['required', 'array', 'min:1'],
            'book_ids.*' => ['required', 'uuid', 'exists:books,id'],
        ]);

        $count = BulkAddBooksToShelf::run($shelf, $request->input('book_ids'), $request->user());

        return response()->json([
            'message' => "Успішно додано {$count} книг до полиці.",
            'count' => $count,
        ], 201);
    }

    public function bulkRemoveBooks(Request $request, Shelf $shelf): JsonResponse
    {
        $request->validate([
            'book_ids' => ['required', 'array', 'min:1'],
            'book_ids.*' => ['required', 'uuid', 'exists:books,id'],
        ]);

        $count = BulkRemoveBooksFromShelf::run($shelf, $request->input('book_ids'), $request->user());

        return response()->json([
            'message' => "Успішно видалено {$count} книг з полиці.",
            'count' => $count,
        ], 200);
    }

    public function stats(Shelf $shelf): JsonResponse
    {
        $stats = GetShelfStats::run($shelf);

        return response()->json($stats);
    }
}
