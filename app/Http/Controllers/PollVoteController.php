<?php

namespace App\Http\Controllers;

use App\Actions\PollVotes\ChangePollVoteOption;
use App\Actions\PollVotes\CreatePollVote;
use App\Actions\PollVotes\GetPollVoteOption;
use App\Actions\PollVotes\GetPollVotePoll;
use App\Actions\PollVotes\GetPollVotes;
use App\Actions\PollVotes\GetPollVoteUser;
use App\Data\PollVote\PollVoteChangeOptionData;
use App\Data\PollVote\PollVoteIndexData;
use App\Data\PollVote\PollVoteStoreData;
use App\Http\Requests\PollVote\PollVoteChangeOptionRequest;
use App\Http\Requests\PollVote\PollVoteDeleteRequest;
use App\Http\Requests\PollVote\PollVoteIndexRequest;
use App\Http\Requests\PollVote\PollVoteStoreRequest;
use App\Http\Resources\GroupPollResource;
use App\Http\Resources\PollOptionResource;
use App\Http\Resources\PollVoteResource;
use App\Http\Resources\UserResource;
use App\Models\PollVote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PollVoteController extends Controller
{
    public function index(PollVoteIndexRequest $request): AnonymousResourceCollection
    {
        $pollVotes = GetPollVotes::run(PollVoteIndexData::fromRequest($request));

        return PollVoteResource::collection($pollVotes);
    }

    public function show(PollVote $pollVote): PollVoteResource
    {
        return new PollVoteResource($pollVote->load(['poll', 'option', 'user']));
    }

    public function store(PollVoteStoreRequest $request): PollVoteResource
    {
        $pollVote = CreatePollVote::run(PollVoteStoreData::fromRequest($request), $request->user());

        return new PollVoteResource($pollVote);
    }

    public function destroy(PollVoteDeleteRequest $request, PollVote $pollVote): JsonResponse
    {
        $pollVote->delete();

        return response()->json([
            'message' => 'Голос успішно видалено.',
        ], 200);
    }

    public function option(PollVote $pollVote): PollOptionResource
    {
        $option = GetPollVoteOption::run($pollVote);

        return new PollOptionResource($option);
    }

    public function user(PollVote $pollVote): UserResource
    {
        $user = GetPollVoteUser::run($pollVote);

        return new UserResource($user);
    }

    public function poll(PollVote $pollVote): GroupPollResource
    {
        $poll = GetPollVotePoll::run($pollVote);

        return new GroupPollResource($poll);
    }

    public function changeOption(PollVoteChangeOptionRequest $request, PollVote $pollVote): PollVoteResource
    {
        $pollVote = ChangePollVoteOption::run($pollVote, PollVoteChangeOptionData::fromRequest($request));

        return new PollVoteResource($pollVote);
    }
}
