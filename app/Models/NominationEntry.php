<?php

namespace App\Models;

use App\Enums\NominationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperNominationEntry
 */
class NominationEntry extends Model {
    use HasFactory;
    protected $fillable = [
        'nomination_id',
        'book_id',
        'author_id',
        'nomination_status',
    ];

    protected $casts = [
        'nomination_status' => NominationStatus::class,
    ];
    public function nomination() { return $this->belongsTo(Nomination::class); }
    public function book() { return $this->belongsTo(Book::class); }
    public function author() { return $this->belongsTo(Author::class); }
}
