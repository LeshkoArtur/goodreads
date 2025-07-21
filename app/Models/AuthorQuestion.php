<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAuthorQuestion
 */
class AuthorQuestion extends Model {
    use HasFactory;
    public function user() { return $this->belongsTo(User::class); }
    public function author() { return $this->belongsTo(Author::class); }
    public function book() { return $this->belongsTo(Book::class); }
    public function answers() { return $this->hasMany(AuthorAnswer::class, 'question_id'); }
}
