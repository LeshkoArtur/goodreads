<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAuthorAnswer
 */
class AuthorAnswer extends Model {
    use HasFactory;
    public function question() { return $this->belongsTo(AuthorQuestion::class); }
    public function author() { return $this->belongsTo(Author::class); }
}
