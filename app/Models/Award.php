<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAward
 */
class Award extends Model {
    use HasFactory;
    protected $casts = [
        'year' => 'integer',
        'ceremony_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'year',
        'description',
        'organizer',
        'country',
        'ceremony_date',
    ];
    public function nominations() { return $this->hasMany(Nomination::class); }
}
