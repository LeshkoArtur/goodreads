<?php

namespace App\Http\Controllers;

use App\Actions\Nominations\CreateNomination;
use App\Actions\Nominations\GetNominationAward;
use App\Actions\Nominations\GetNominationCreator;
use App\Actions\Nominations\GetNominationEntries;
use App\Actions\Nominations\GetNominations;
use App\Actions\Nominations\UpdateNomination;
use App\Actions\Nominations\VoteOnNomination;
use App\Data\Nomination\NominationIndexData;
use App\Data\Nomination\NominationRelationIndexData;
use App\Data\Nomination\NominationStoreData;
use App\Data\Nomination\NominationUpdateData;
use App\Http\Requests\Nomination\NominationDeleteRequest;
use App\Http\Requests\Nomination\NominationIndexRequest;
use App\Http\Requests\Nomination\NominationRelationRequest;
use App\Http\Requests\Nomination\NominationStoreRequest;
use App\Http\Requests\Nomination\NominationUpdateRequest;
use App\Http\Requests\Nomination\NominationVoteRequest;
use App\Http\Resources\AwardResource;
use App\Http\Resources\NominationEntryResource;
use App\Http\Resources\NominationResource;
use App\Http\Resources\UserResource;
use App\Models\Nomination;
use App\Models\NominationEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NominationController extends Controller
{
    public function index(NominationIndexRequest $request): AnonymousResourceCollection
    {
        $nominations = GetNominations::run(NominationIndexData::fromRequest($request));

        return NominationResource::collection($nominations);
    }

    public function show(Nomination $nomination): NominationResource
    {
        return new NominationResource($nomination->load(['award']));
    }

    public function store(NominationStoreRequest $request): NominationResource
    {
        $nomination = CreateNomination::run(NominationStoreData::fromRequest($request));

        return new NominationResource($nomination);
    }

    public function update(NominationUpdateRequest $request, Nomination $nomination): NominationResource
    {
        $nomination = UpdateNomination::run($nomination, NominationUpdateData::fromRequest($request));

        return new NominationResource($nomination);
    }

    public function destroy(NominationDeleteRequest $request, Nomination $nomination): JsonResponse
    {
        $nomination->delete();

        return response()->json([
            'message' => 'Номінацію успішно видалено.',
        ], 200);
    }

    public function award(Nomination $nomination): AwardResource
    {
        $award = GetNominationAward::run($nomination);

        return new AwardResource($award);
    }

    public function entries(NominationRelationRequest $request, Nomination $nomination): AnonymousResourceCollection
    {
        $entries = GetNominationEntries::run($nomination, NominationRelationIndexData::fromRequest($request));

        return NominationEntryResource::collection($entries);
    }

    public function creator(Nomination $nomination): JsonResponse
    {
        $creator = GetNominationCreator::run($nomination);

        if (! $creator) {
            return response()->json([
                'message' => 'Створювач не знайдений.',
            ], 404);
        }

        return response()->json(new UserResource($creator));
    }

    public function vote(NominationVoteRequest $request, Nomination $nomination, NominationEntry $entry): JsonResponse
    {
        $voted = VoteOnNomination::run($entry, $request->user());

        return response()->json([
            'message' => $voted ? 'Голос успішно додано.' : 'Ви вже проголосували.',
            'voted' => $voted,
        ], 200);
    }
}
