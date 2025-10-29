<?php

namespace App\Http\Controllers;

use App\Actions\PollOptions\CreatePollOption;
use App\Actions\PollOptions\GetPollOptionPoll;
use App\Actions\PollOptions\GetPollOptions;
use App\Actions\PollOptions\GetPollOptionVoteCount;
use App\Actions\PollOptions\GetPollOptionVotes;
use App\Actions\PollOptions\UpdatePollOption;
use App\Data\PollOption\PollOptionIndexData;
use App\Data\PollOption\PollOptionRelationIndexData;
use App\Data\PollOption\PollOptionStoreData;
use App\Data\PollOption\PollOptionUpdateData;
use App\Http\Requests\PollOption\PollOptionDeleteRequest;
use App\Http\Requests\PollOption\PollOptionIndexRequest;
use App\Http\Requests\PollOption\PollOptionRelationRequest;
use App\Http\Requests\PollOption\PollOptionStoreRequest;
use App\Http\Requests\PollOption\PollOptionUpdateRequest;
use App\Http\Resources\GroupPollResource;
use App\Http\Resources\PollOptionResource;
use App\Http\Resources\PollVoteResource;
use App\Models\PollOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PollOptionController extends Controller
{
    public function index(PollOptionIndexRequest $request): AnonymousResourceCollection
    {
        $pollOptions = GetPollOptions::run(PollOptionIndexData::fromRequest($request));

        return PollOptionResource::collection($pollOptions);
    }

    public function show(PollOption $pollOption): PollOptionResource
    {
        return new PollOptionResource($pollOption->load(['poll']));
    }

    public function store(PollOptionStoreRequest $request): PollOptionResource
    {
        $pollOption = CreatePollOption::run(PollOptionStoreData::fromRequest($request));

        return new PollOptionResource($pollOption);
    }

    public function update(PollOptionUpdateRequest $request, PollOption $pollOption): PollOptionResource
    {
        $pollOption = UpdatePollOption::run($pollOption, PollOptionUpdateData::fromRequest($request));

        return new PollOptionResource($pollOption);
    }

    public function destroy(PollOptionDeleteRequest $request, PollOption $pollOption): JsonResponse
    {
        $pollOption->delete();

        return response()->json([
            'message' => 'Варіант опитування успішно видалено.',
        ], 200);
    }

    public function poll(PollOption $pollOption): GroupPollResource
    {
        $poll = GetPollOptionPoll::run($pollOption);

        return new GroupPollResource($poll);
    }

    public function votes(PollOptionRelationRequest $request, PollOption $pollOption): AnonymousResourceCollection
    {
        $votes = GetPollOptionVotes::run($pollOption, PollOptionRelationIndexData::fromRequest($request));

        return PollVoteResource::collection($votes);
    }

    public function voteCount(PollOption $pollOption): JsonResponse
    {
        $voteCount = GetPollOptionVoteCount::run($pollOption);

        return response()->json([
            'vote_count' => $voteCount,
        ]);
    }
}
