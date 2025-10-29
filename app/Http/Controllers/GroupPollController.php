<?php

namespace App\Http\Controllers;

use App\Actions\GroupPolls\CreateGroupPoll;
use App\Actions\GroupPolls\GetGroupPollGroup;
use App\Actions\GroupPolls\GetGroupPollOptions;
use App\Actions\GroupPolls\GetGroupPollResults;
use App\Actions\GroupPolls\GetGroupPolls;
use App\Actions\GroupPolls\GetGroupPollVotes;
use App\Actions\GroupPolls\UnvoteFromGroupPoll;
use App\Actions\GroupPolls\UpdateGroupPoll;
use App\Actions\GroupPolls\VoteOnGroupPoll;
use App\Data\GroupPoll\GroupPollIndexData;
use App\Data\GroupPoll\GroupPollRelationIndexData;
use App\Data\GroupPoll\GroupPollStoreData;
use App\Data\GroupPoll\GroupPollUpdateData;
use App\Data\GroupPoll\GroupPollVoteData;
use App\Http\Requests\GroupPoll\GroupPollDeleteRequest;
use App\Http\Requests\GroupPoll\GroupPollIndexRequest;
use App\Http\Requests\GroupPoll\GroupPollRelationRequest;
use App\Http\Requests\GroupPoll\GroupPollStoreRequest;
use App\Http\Requests\GroupPoll\GroupPollUpdateRequest;
use App\Http\Requests\GroupPoll\GroupPollVoteRequest;
use App\Http\Resources\GroupPollResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\PollOptionResource;
use App\Http\Resources\PollVoteResource;
use App\Models\GroupPoll;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupPollController extends Controller
{
    public function index(GroupPollIndexRequest $request): AnonymousResourceCollection
    {
        $groupPolls = GetGroupPolls::run(GroupPollIndexData::fromRequest($request));

        return GroupPollResource::collection($groupPolls);
    }

    public function show(GroupPoll $groupPoll): GroupPollResource
    {
        return new GroupPollResource($groupPoll->load(['group', 'creator', 'options']));
    }

    public function store(GroupPollStoreRequest $request): GroupPollResource
    {
        $groupPoll = CreateGroupPoll::run(GroupPollStoreData::fromRequest($request), $request->user());

        return new GroupPollResource($groupPoll);
    }

    public function update(GroupPollUpdateRequest $request, GroupPoll $groupPoll): GroupPollResource
    {
        $groupPoll = UpdateGroupPoll::run($groupPoll, GroupPollUpdateData::fromRequest($request));

        return new GroupPollResource($groupPoll);
    }

    public function destroy(GroupPollDeleteRequest $request, GroupPoll $groupPoll): JsonResponse
    {
        $groupPoll->delete();

        return response()->json([
            'message' => 'Опитування групи успішно видалено.',
        ], 200);
    }

    public function group(GroupPoll $groupPoll): GroupResource
    {
        $group = GetGroupPollGroup::run($groupPoll);

        return new GroupResource($group);
    }

    public function options(GroupPollRelationRequest $request, GroupPoll $groupPoll): AnonymousResourceCollection
    {
        $options = GetGroupPollOptions::run($groupPoll, GroupPollRelationIndexData::fromRequest($request));

        return PollOptionResource::collection($options);
    }

    public function votes(GroupPollRelationRequest $request, GroupPoll $groupPoll): AnonymousResourceCollection
    {
        $votes = GetGroupPollVotes::run($groupPoll, GroupPollRelationIndexData::fromRequest($request));

        return PollVoteResource::collection($votes);
    }

    public function results(GroupPoll $groupPoll): JsonResponse
    {
        $results = GetGroupPollResults::run($groupPoll);

        return response()->json($results);
    }

    public function vote(GroupPollVoteRequest $request, GroupPoll $groupPoll): PollVoteResource
    {
        $vote = VoteOnGroupPoll::run($groupPoll, GroupPollVoteData::fromRequest($request), $request->user());

        return new PollVoteResource($vote);
    }

    public function unvote(Request $request, GroupPoll $groupPoll): JsonResponse
    {
        $success = UnvoteFromGroupPoll::run($groupPoll, $request->user());

        if (! $success) {
            return response()->json([
                'message' => 'Ви не голосували в цьому опитуванні.',
            ], 404);
        }

        return response()->json([
            'message' => 'Голос успішно видалено.',
        ], 200);
    }
}
