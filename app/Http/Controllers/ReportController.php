<?php

namespace App\Http\Controllers;

use App\Actions\Reports\CreateReport;
use App\Actions\Reports\DismissReport;
use App\Actions\Reports\GetDismissedReports;
use App\Actions\Reports\GetPendingReports;
use App\Actions\Reports\GetReports;
use App\Actions\Reports\GetReportsByType;
use App\Actions\Reports\GetResolvedReports;
use App\Actions\Reports\GetReviewedReports;
use App\Actions\Reports\MarkReviewed;
use App\Actions\Reports\ResolveReport;
use App\Actions\Reports\UpdateReport;
use App\Data\Report\ReportIndexData;
use App\Data\Report\ReportStoreData;
use App\Data\Report\ReportUpdateData;
use App\Enums\ReportType;
use App\Http\Requests\Report\ReportDeleteRequest;
use App\Http\Requests\Report\ReportIndexRequest;
use App\Http\Requests\Report\ReportStoreRequest;
use App\Http\Requests\Report\ReportUpdateRequest;
use App\Http\Resources\ReportResource;
use App\Http\Resources\UserResource;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    public function index(ReportIndexRequest $request): AnonymousResourceCollection
    {
        $reports = GetReports::run(ReportIndexData::fromRequest($request));

        return ReportResource::collection($reports);
    }

    public function show(Report $report): ReportResource
    {
        return new ReportResource($report->load(['user', 'reportable']));
    }

    public function store(ReportStoreRequest $request): ReportResource
    {
        $report = CreateReport::run(ReportStoreData::fromRequest($request));

        return new ReportResource($report);
    }

    public function update(ReportUpdateRequest $request, Report $report): ReportResource
    {
        $report = UpdateReport::run($report, ReportUpdateData::fromRequest($request));

        return new ReportResource($report);
    }

    public function destroy(ReportDeleteRequest $request, Report $report): JsonResponse
    {
        $report->delete();

        return response()->json([
            'message' => 'Звіт успішно видалено.',
        ], 200);
    }

    public function reporter(Report $report): UserResource
    {
        return new UserResource($report->user);
    }

    public function reportable(Report $report): JsonResponse
    {
        $reportable = $report->reportable;

        if (! $reportable) {
            return response()->json([
                'message' => 'Об\'єкт звіту не знайдено.',
            ], 404);
        }

        return response()->json([
            'id' => $reportable->id,
            'type' => class_basename($report->reportable_type),
            'data' => $reportable,
        ]);
    }

    public function pending(): AnonymousResourceCollection
    {
        $reports = GetPendingReports::run();

        return ReportResource::collection($reports);
    }

    public function reviewed(): AnonymousResourceCollection
    {
        $reports = GetReviewedReports::run();

        return ReportResource::collection($reports);
    }

    public function resolved(): AnonymousResourceCollection
    {
        $reports = GetResolvedReports::run();

        return ReportResource::collection($reports);
    }

    public function dismissed(): AnonymousResourceCollection
    {
        $reports = GetDismissedReports::run();

        return ReportResource::collection($reports);
    }

    public function byType(string $type): AnonymousResourceCollection
    {
        try {
            $reportType = ReportType::from($type);
            $reports = GetReportsByType::run($reportType);

            return ReportResource::collection($reports);
        } catch (\ValueError $e) {
            return ReportResource::collection(collect());
        }
    }

    public function markReviewed(Report $report): ReportResource
    {
        $report = MarkReviewed::run($report);

        return new ReportResource($report);
    }

    public function resolve(Report $report): ReportResource
    {
        $report = ResolveReport::run($report);

        return new ReportResource($report);
    }

    public function dismiss(Report $report): ReportResource
    {
        $report = DismissReport::run($report);

        return new ReportResource($report);
    }
}
