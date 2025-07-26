<?php

namespace App\Models;

use App\Enums\AnswerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAuthorAnswer
 */
class AuthorAnswer extends Model {
    use HasFactory;
    protected $casts = [
        'published_at' => 'datetime',
        'answer_status' => AnswerStatus::class,
    ];
    protected $fillable = [
        'question_id',
        'author_id',
        'content',
        'published_at',
        'answer_status',
    ];
    public function question() { return $this->belongsTo(AuthorQuestion::class); }
    public function author() { return $this->belongsTo(Author::class); }
}
