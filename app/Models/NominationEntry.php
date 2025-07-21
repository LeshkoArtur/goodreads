<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperNominationEntry
 */
class NominationEntry extends Model {
    use HasFactory;
    public function nomination() { return $this->belongsTo(Nomination::class); }
    public function book() { return $this->belongsTo(Book::class); }
    public function author() { return $this->belongsTo(Author::class); }
}
