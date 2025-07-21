<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCollection
 */
class Collection extends Model {
    use HasFactory;
    public function user() { return $this->belongsTo(User::class); }
    public function books() {
        return $this->belongsToMany(Book::class, 'collection_books')->withPivot('order_index');
    }
}
