<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperNomination
 */
class Nomination extends Model {
    use HasFactory;
    protected $fillable = [
        'id',
        'award_id',
        'name',
        'description',
    ];
    public function award() { return $this->belongsTo(Award::class); }
    public function entries() { return $this->hasMany(NominationEntry::class); }
}
