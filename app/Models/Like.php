<?php

namespace App\Models;

use App\Models\Builders\LikeQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin IdeHelperLike
 */
class Like extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    public function newEloquentBuilder($query): LikeQueryBuilder
    {
        return new LikeQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}
