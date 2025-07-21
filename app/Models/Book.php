<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBook
 */
class Book extends Model {
    use HasFactory;
    public function authors() { return $this->belongsToMany(Author::class, 'book_authors'); }
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
