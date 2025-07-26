<?php

namespace App\Models;

use App\Enums\QuestionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAuthorQuestion
 */
class AuthorQuestion extends Model {
    use HasFactory;
    protected $casts = [
        'question_status' => QuestionStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'user_id',
        'author_id',
        'book_id',
        'content',
        'question_status',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function author() { return $this->belongsTo(Author::class); }
    public function book() { return $this->belongsTo(Book::class); }
    public function answers() { return $this->hasMany(AuthorAnswer::class, 'question_id'); }
}
