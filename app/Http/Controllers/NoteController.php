<?php

namespace App\Http\Controllers;

use App\Actions\Notes\CreateNote;
use App\Actions\Notes\GetNotes;
use App\Actions\Notes\GetNoteUserBook;
use App\Actions\Notes\MakeNotePrivate;
use App\Actions\Notes\ShareNote;
use App\Actions\Notes\UpdateNote;
use App\Data\Note\NoteIndexData;
use App\Data\Note\NoteStoreData;
use App\Data\Note\NoteUpdateData;
use App\Http\Requests\Note\NoteDeleteRequest;
use App\Http\Requests\Note\NoteIndexRequest;
use App\Http\Requests\Note\NoteStoreRequest;
use App\Http\Requests\Note\NoteUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\NoteResource;
use App\Http\Resources\UserBookResource;
use App\Http\Resources\UserResource;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NoteController extends Controller
{
    public function index(NoteIndexRequest $request): AnonymousResourceCollection
    {
        $notes = GetNotes::run(NoteIndexData::fromRequest($request));

        return NoteResource::collection($notes);
    }

    public function show(Note $note): NoteResource
    {
        return new NoteResource($note->load(['user', 'book']));
    }

    public function store(NoteStoreRequest $request): NoteResource
    {
        $note = CreateNote::run(NoteStoreData::fromRequest($request));

        return new NoteResource($note);
    }

    public function update(NoteUpdateRequest $request, Note $note): NoteResource
    {
        $note = UpdateNote::run($note, NoteUpdateData::fromRequest($request));

        return new NoteResource($note);
    }

    public function destroy(NoteDeleteRequest $request, Note $note): JsonResponse
    {
        $note->delete();

        return response()->json([
            'message' => 'Нотатку успішно видалено.',
        ], 200);
    }

    public function user(Note $note): UserResource
    {
        return new UserResource($note->user);
    }

    public function book(Note $note): BookResource
    {
        return new BookResource($note->book);
    }

    public function userBook(Note $note): JsonResponse
    {
        $userBook = GetNoteUserBook::run($note);

        if (! $userBook) {
            return response()->json([
                'message' => 'Користувач не має цієї книги у своїй бібліотеці.',
            ], 404);
        }

        return response()->json(new UserBookResource($userBook));
    }

    public function share(Request $request, Note $note): NoteResource
    {
        $note = ShareNote::run($note);

        return new NoteResource($note);
    }

    public function makePrivate(Request $request, Note $note): NoteResource
    {
        $note = MakeNotePrivate::run($note);

        return new NoteResource($note);
    }
}
