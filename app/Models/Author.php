<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin IdeHelperAuthor
 */
class Author extends Model {
    use HasFactory;
    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'type_of_work' => TypeOfWork::class,
        'social_media_links' => 'array',
        'media_images' => 'array',
        'media_videos' => 'array',
        'fun_facts' => 'array',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    public function users() { return $this->belongsToMany(User::class, 'user_authors'); }
    public function books() { return $this->belongsToMany(Book::class, 'author_book'); }
    public function nominations() { return $this->hasMany(NominationEntry::class); }
    public function questions() { return $this->hasMany(AuthorQuestion::class); }
    public function answers() { return $this->hasMany(AuthorAnswer::class); }
    public function posts() { return $this->hasMany(Post::class); }
}
