<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAuthor
 */
class Author extends Model {
    use HasFactory;
    protected $casts = [
        'social_media_links' => 'array',
        'media_images' => 'array',
        'media_videos' => 'array',
        'fun_facts' => 'array',
        'birth_date' => 'date',
        'death_date' => 'date',
    ];
    public function users() { return $this->belongsToMany(User::class, 'user_authors'); }
    public function books() { return $this->belongsToMany(Book::class, 'book_authors'); }
    public function nominations() { return $this->hasMany(NominationEntry::class); }
    public function questions() { return $this->hasMany(AuthorQuestion::class); }
    public function answers() { return $this->hasMany(AuthorAnswer::class); }
    public function posts() { return $this->hasMany(Post::class); }
}
