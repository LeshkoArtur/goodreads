<?php

namespace App\Http\Controllers;

use App\Actions\NominationEntries\ApproveNominationEntry;
use App\Actions\NominationEntries\CreateNominationEntry;
use App\Actions\NominationEntries\GetNominationEntries;
use App\Actions\NominationEntries\GetNominationEntryAuthor;
use App\Actions\NominationEntries\GetNominationEntryAward;
use App\Actions\NominationEntries\GetNominationEntryBook;
use App\Actions\NominationEntries\GetNominationEntryNomination;
use App\Actions\NominationEntries\GetNominationEntryVoteCount;
use App\Actions\NominationEntries\MarkNominationEntryWinner;
use App\Actions\NominationEntries\RejectNominationEntry;
use App\Actions\NominationEntries\UpdateNominationEntry;
use App\Data\NominationEntry\NominationEntryIndexData;
use App\Data\NominationEntry\NominationEntryStoreData;
use App\Data\NominationEntry\NominationEntryUpdateData;
use App\Http\Requests\NominationEntry\NominationEntryDeleteRequest;
use App\Http\Requests\NominationEntry\NominationEntryIndexRequest;
use App\Http\Requests\NominationEntry\NominationEntryStoreRequest;
use App\Http\Requests\NominationEntry\NominationEntryUpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\AwardResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\NominationEntryResource;
use App\Http\Resources\NominationResource;
use App\Models\NominationEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NominationEntryController extends Controller
{
    public function index(NominationEntryIndexRequest $request): AnonymousResourceCollection
    {
        $entries = GetNominationEntries::run(NominationEntryIndexData::fromRequest($request));

        return NominationEntryResource::collection($entries);
    }

    public function show(NominationEntry $nominationEntry): NominationEntryResource
    {
        return new NominationEntryResource($nominationEntry->load(['nomination', 'book', 'author']));
    }

    public function store(NominationEntryStoreRequest $request): NominationEntryResource
    {
        $entry = CreateNominationEntry::run(NominationEntryStoreData::fromRequest($request));

        return new NominationEntryResource($entry);
    }

    public function update(NominationEntryUpdateRequest $request, NominationEntry $nominationEntry): NominationEntryResource
    {
        $entry = UpdateNominationEntry::run($nominationEntry, NominationEntryUpdateData::fromRequest($request));

        return new NominationEntryResource($entry);
    }

    public function destroy(NominationEntryDeleteRequest $request, NominationEntry $nominationEntry): JsonResponse
    {
        $nominationEntry->delete();

        return response()->json([
            'message' => 'Запис номінації успішно видалено.',
        ], 200);
    }

    public function nomination(NominationEntry $nominationEntry): NominationResource
    {
        $nomination = GetNominationEntryNomination::run($nominationEntry);

        return new NominationResource($nomination);
    }

    public function award(NominationEntry $nominationEntry): AwardResource
    {
        $award = GetNominationEntryAward::run($nominationEntry);

        return new AwardResource($award);
    }

    public function book(NominationEntry $nominationEntry): JsonResponse
    {
        $book = GetNominationEntryBook::run($nominationEntry);

        if (! $book) {
            return response()->json([
                'message' => 'Книга не знайдена для цього запису.',
            ], 404);
        }

        return response()->json(new BookResource($book));
    }

    public function author(NominationEntry $nominationEntry): JsonResponse
    {
        $author = GetNominationEntryAuthor::run($nominationEntry);

        if (! $author) {
            return response()->json([
                'message' => 'Автор не знайдений для цього запису.',
            ], 404);
        }

        return response()->json(new AuthorResource($author));
    }

    public function voteCount(NominationEntry $nominationEntry): JsonResponse
    {
        $count = GetNominationEntryVoteCount::run($nominationEntry);

        return response()->json([
            'vote_count' => $count,
        ]);
    }

    public function approve(Request $request, NominationEntry $nominationEntry): NominationEntryResource
    {
        $entry = ApproveNominationEntry::run($nominationEntry);

        return new NominationEntryResource($entry);
    }

    public function reject(Request $request, NominationEntry $nominationEntry): NominationEntryResource
    {
        $entry = RejectNominationEntry::run($nominationEntry);

        return new NominationEntryResource($entry);
    }

    public function markWinner(Request $request, NominationEntry $nominationEntry): NominationEntryResource
    {
        $entry = MarkNominationEntryWinner::run($nominationEntry);

        return new NominationEntryResource($entry);
    }
}
