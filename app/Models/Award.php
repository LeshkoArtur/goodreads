<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperAward
 */
class Award extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'year',
        'description',
        'organizer',
        'country',
        'ceremony_date',
    ];

    protected $casts = [
        'year' => 'integer',
        'ceremony_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function nominations(): HasMany
    {
        return $this->hasMany(Nomination::class);
    }
}
