<?php

namespace App\Http\Controllers;

use App\Actions\Awards\CreateAward;
use App\Actions\Awards\GetAwardEntries;
use App\Actions\Awards\GetAwardNominations;
use App\Actions\Awards\GetAwards;
use App\Actions\Awards\GetAwardStats;
use App\Actions\Awards\GetAwardWinners;
use App\Actions\Awards\UpdateAward;
use App\Data\Award\AwardIndexData;
use App\Data\Award\AwardRelationIndexData;
use App\Data\Award\AwardStoreData;
use App\Data\Award\AwardUpdateData;
use App\Http\Requests\Award\AwardDeleteRequest;
use App\Http\Requests\Award\AwardIndexRequest;
use App\Http\Requests\Award\AwardRelationRequest;
use App\Http\Requests\Award\AwardStoreRequest;
use App\Http\Requests\Award\AwardUpdateRequest;
use App\Http\Resources\AwardResource;
use App\Http\Resources\NominationResource;
use App\Models\Award;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AwardController extends Controller
{
    public function index(AwardIndexRequest $request): AnonymousResourceCollection
    {
        $awards = GetAwards::run(AwardIndexData::fromRequest($request));

        return AwardResource::collection($awards);
    }

    public function show(Award $award): AwardResource
    {
        return new AwardResource($award);
    }

    public function store(AwardStoreRequest $request): AwardResource
    {
        $award = CreateAward::run(AwardStoreData::fromRequest($request));

        return new AwardResource($award);
    }

    public function update(AwardUpdateRequest $request, Award $award): AwardResource
    {
        $award = UpdateAward::run($award, AwardUpdateData::fromRequest($request));

        return new AwardResource($award);
    }

    public function destroy(AwardDeleteRequest $request, Award $award): JsonResponse
    {
        $award->delete();

        return response()->json([
            'message' => 'Нагороду успішно видалено.',
        ], 200);
    }

    public function nominations(AwardRelationRequest $request, Award $award): AnonymousResourceCollection
    {
        $nominations = GetAwardNominations::run($award, AwardRelationIndexData::fromRequest($request));

        return NominationResource::collection($nominations);
    }

    public function entries(AwardRelationRequest $request, Award $award): AnonymousResourceCollection
    {
        $entries = GetAwardEntries::run($award, AwardRelationIndexData::fromRequest($request));

        return NominationResource::collection($entries);
    }

    public function winners(AwardRelationRequest $request, Award $award): AnonymousResourceCollection
    {
        $winners = GetAwardWinners::run($award, AwardRelationIndexData::fromRequest($request));

        return NominationResource::collection($winners);
    }

    public function stats(Award $award): JsonResponse
    {
        $stats = GetAwardStats::run($award);

        return response()->json($stats);
    }
}
