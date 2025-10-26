<?php

namespace App\Models;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Models\Builders\ReportQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperReport
 */
class Report extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'user_id',
        'type',
        'reportable_id',
        'reportable_type',
        'description',
        'status',
    ];

    protected $casts = [
        'type' => ReportType::class,
        'status' => ReportStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): ReportQueryBuilder
    {
        return new ReportQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'reportable_id' => $this->reportable_id,
            'reportable_type' => $this->reportable_type,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }

    public function searchableAs(): string
    {
        return 'reports';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'user_id',
                'reportable_type',
                'reportable_id',
                'type',
                'status',
            ],
            'sortableAttributes' => ['created_at'],
        ];
    }
}
