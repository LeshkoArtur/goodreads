<?php

namespace App\Http\Controllers;

use App\Actions\ReadingStats\CreateReadingStat;
use App\Actions\ReadingStats\GetMonthlyStats;
use App\Actions\ReadingStats\GetReadingStats;
use App\Actions\ReadingStats\GetSummary;
use App\Actions\ReadingStats\GetYearlyStats;
use App\Actions\ReadingStats\TrackSession;
use App\Actions\ReadingStats\UpdateReadingStat;
use App\Data\ReadingStat\ReadingStatIndexData;
use App\Data\ReadingStat\ReadingStatStoreData;
use App\Data\ReadingStat\ReadingStatUpdateData;
use App\Http\Requests\ReadingStat\ReadingStatDeleteRequest;
use App\Http\Requests\ReadingStat\ReadingStatIndexRequest;
use App\Http\Requests\ReadingStat\ReadingStatStoreRequest;
use App\Http\Requests\ReadingStat\ReadingStatUpdateRequest;
use App\Http\Requests\ReadingStat\TrackSessionRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\ReadingStatResource;
use App\Http\Resources\UserResource;
use App\Models\ReadingStat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReadingStatController extends Controller
{
    public function index(ReadingStatIndexRequest $request): AnonymousResourceCollection
    {
        $readingStats = GetReadingStats::run(ReadingStatIndexData::fromRequest($request));

        return ReadingStatResource::collection($readingStats);
    }

    public function show(ReadingStat $readingStat): ReadingStatResource
    {
        return new ReadingStatResource($readingStat->load(['user']));
    }

    public function store(ReadingStatStoreRequest $request): ReadingStatResource
    {
        $readingStat = CreateReadingStat::run(ReadingStatStoreData::fromRequest($request));

        return new ReadingStatResource($readingStat);
    }

    public function update(ReadingStatUpdateRequest $request, ReadingStat $readingStat): ReadingStatResource
    {
        $readingStat = UpdateReadingStat::run($readingStat, ReadingStatUpdateData::fromRequest($request));

        return new ReadingStatResource($readingStat);
    }

    public function destroy(ReadingStatDeleteRequest $request, ReadingStat $readingStat): JsonResponse
    {
        $readingStat->delete();

        return response()->json([
            'message' => 'Статистику читання успішно видалено.',
        ], 200);
    }

    public function user(ReadingStat $readingStat): UserResource
    {
        return new UserResource($readingStat->user);
    }

    public function book(ReadingStat $readingStat): JsonResponse
    {
        return response()->json([
            'message' => 'Статистика читання не прив\'язана до конкретної книги.',
        ], 404);
    }

    public function yearlyStats(User $user): JsonResponse|ReadingStatResource
    {
        $year = request()->query('year');
        $stats = GetYearlyStats::run($user, $year);

        if (! $stats) {
            return response()->json([
                'message' => 'Статистика за цей рік не знайдена.',
            ], 404);
        }

        return new ReadingStatResource($stats);
    }

    public function monthlyStats(User $user): JsonResponse
    {
        $year = request()->query('year');
        $stats = GetMonthlyStats::run($user, $year);

        return response()->json([
            'year' => $year ?? now()->year,
            'monthly_stats' => $stats,
        ]);
    }

    public function summary(User $user): JsonResponse
    {
        $summary = GetSummary::run($user);

        return response()->json($summary);
    }

    public function trackSession(TrackSessionRequest $request): ReadingStatResource
    {
        $readingStat = TrackSession::run(
            $request->user(),
            $request->validated('pages_read'),
            $request->validated('genres_read')
        );

        return new ReadingStatResource($readingStat);
    }
}
