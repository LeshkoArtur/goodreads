<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperNomination
 */
class Nomination extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'award_id',
        'name',
        'description',
    ];

    public function award(): BelongsTo
    {
        return $this->belongsTo(Award::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(NominationEntry::class);
    }
}
