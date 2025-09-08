<?php

namespace App\Models;

use App\Models\Builders\ViewHistoryQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperViewHistory
 */
class ViewHistory extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'user_id',
        'viewable_id',
        'viewable_type',
    ];

    public function newEloquentBuilder($query): ViewHistoryQueryBuilder
    {
        return new ViewHistoryQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'viewable_id' => $this->viewable_id,
            'viewable_type' => $this->viewable_type,
        ];
    }

    public function searchableAs(): string
    {
        return 'view_histories';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'user_id',
                'viewable_type',
                'viewable_id',
                'created_at',
            ],
            'sortableAttributes' => ['created_at'],
        ];
    }
}
