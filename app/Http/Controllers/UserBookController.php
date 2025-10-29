<?php

namespace App\Http\Controllers;

use App\Actions\UserBooks\CreateUserBook;
use App\Actions\UserBooks\GetUserBookNotes;
use App\Actions\UserBooks\GetUserBookQuotes;
use App\Actions\UserBooks\GetUserBookRatings;
use App\Actions\UserBooks\GetUserBooks;
use App\Actions\UserBooks\MarkUserBookFinished;
use App\Actions\UserBooks\UpdateUserBook;
use App\Actions\UserBooks\UpdateUserBookProgress;
use App\Actions\UserBooks\UpdateUserBookStatus;
use App\Data\UserBook\UserBookIndexData;
use App\Data\UserBook\UserBookRelationIndexData;
use App\Data\UserBook\UserBookStoreData;
use App\Data\UserBook\UserBookUpdateData;
use App\Http\Requests\UserBook\UserBookDeleteRequest;
use App\Http\Requests\UserBook\UserBookIndexRequest;
use App\Http\Requests\UserBook\UserBookRelationRequest;
use App\Http\Requests\UserBook\UserBookStoreRequest;
use App\Http\Requests\UserBook\UserBookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\NoteResource;
use App\Http\Resources\QuoteResource;
use App\Http\Resources\RatingResource;
use App\Http\Resources\UserBookResource;
use App\Http\Resources\UserResource;
use App\Models\UserBook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserBookController extends Controller
{
    public function index(UserBookIndexRequest $request): AnonymousResourceCollection
    {
        $userBooks = GetUserBooks::run(UserBookIndexData::fromRequest($request));

        return UserBookResource::collection($userBooks);
    }

    public function show(UserBook $userBook): UserBookResource
    {
        return new UserBookResource($userBook->load(['user', 'book', 'shelf']));
    }

    public function store(UserBookStoreRequest $request): UserBookResource
    {
        $userBook = CreateUserBook::run(UserBookStoreData::fromRequest($request));

        return new UserBookResource($userBook);
    }

    public function update(UserBookUpdateRequest $request, UserBook $userBook): UserBookResource
    {
        $userBook = UpdateUserBook::run($userBook, UserBookUpdateData::fromRequest($request));

        return new UserBookResource($userBook);
    }

    public function destroy(UserBookDeleteRequest $request, UserBook $userBook): JsonResponse
    {
        $userBook->delete();

        return response()->json([
            'message' => 'Книгу успішно видалено з бібліотеки користувача.',
        ], 200);
    }

    public function user(UserBook $userBook): UserResource
    {
        return new UserResource($userBook->user);
    }

    public function book(UserBook $userBook): BookResource
    {
        return new BookResource($userBook->book);
    }

    public function ratings(UserBookRelationRequest $request, UserBook $userBook): AnonymousResourceCollection
    {
        $ratings = GetUserBookRatings::run($userBook, UserBookRelationIndexData::fromRequest($request));

        return RatingResource::collection($ratings);
    }

    public function notes(UserBookRelationRequest $request, UserBook $userBook): AnonymousResourceCollection
    {
        $notes = GetUserBookNotes::run($userBook, UserBookRelationIndexData::fromRequest($request));

        return NoteResource::collection($notes);
    }

    public function quotes(UserBookRelationRequest $request, UserBook $userBook): AnonymousResourceCollection
    {
        $quotes = GetUserBookQuotes::run($userBook, UserBookRelationIndexData::fromRequest($request));

        return QuoteResource::collection($quotes);
    }

    public function updateProgress(Request $request, UserBook $userBook): UserBookResource
    {
        $request->validate([
            'progress_pages' => ['required', 'integer', 'min:0'],
        ]);

        $userBook = UpdateUserBookProgress::run($userBook, $request->input('progress_pages'));

        return new UserBookResource($userBook);
    }

    public function updateStatus(Request $request, UserBook $userBook): UserBookResource
    {
        $request->validate([
            'shelf_id' => ['required', 'uuid', 'exists:shelves,id'],
        ]);

        $userBook = UpdateUserBookStatus::run($userBook, $request->input('shelf_id'));

        return new UserBookResource($userBook);
    }

    public function markFinished(Request $request, UserBook $userBook): UserBookResource
    {
        $userBook = MarkUserBookFinished::run($userBook);

        return new UserBookResource($userBook);
    }
}
