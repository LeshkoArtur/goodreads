<?php

namespace App\Models;

use App\Enums\AgeRestriction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBook
 */
class Book extends Model {
    use HasFactory;
    protected $casts = [
        'series_id' => 'string',
        'number_in_series' => 'integer',
        'page_count' => 'integer',
        'languages' => 'array',
        'fun_facts' => 'array',
        'adaptations' => 'array',
        'is_bestseller' => 'boolean',
        'average_rating' => 'decimal:2',
        'age_restriction' => AgeRestriction::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'title',
        'description',
        'plot',
        'history',
        'series_id',
        'number_in_series',
        'page_count',
        'languages',
        'cover_image',
        'fun_facts',
        'adaptations',
        'is_bestseller',
        'average_rating',
        'age_restriction',
    ];

    public function authors() { return $this->belongsToMany(Author::class, 'author_book'); }
    public function genres() { return $this->belongsToMany(Genre::class, 'book_genres'); }
    public function publishers() {
        return $this->belongsToMany(Publisher::class, 'book_publishers')
            ->withPivot(['published_date', 'isbn', 'circulation', 'format', 'cover_type', 'translator', 'edition', 'price', 'binding']);
    }
    public function userBooks() { return $this->hasMany(UserBook::class); }
    public function ratings() { return $this->hasMany(Rating::class); }
    public function quotes() { return $this->hasMany(Quote::class); }
    public function notes() { return $this->hasMany(Note::class); }
    public function nominationEntries() { return $this->hasMany(NominationEntry::class); }
    public function characters() { return $this->hasMany(Character::class); }
    public function collections() {
        return $this->belongsToMany(Collection::class, 'collection_books')->withPivot('order_index');
    }
    public function posts() { return $this->hasMany(Post::class); }
}
