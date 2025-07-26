<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPublisher
 */
class Publisher extends Model {
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'website',
        'country',
        'founded_year',
        'logo',
        'contact_email',
        'phone',
    ];

    protected $casts = [
        'founded_year' => 'integer',
    ];
    public function books() {
        return $this->belongsToMany(Book::class, 'book_publishers')
            ->withPivot(['published_date', 'isbn', 'circulation', 'format', 'cover_type', 'translator', 'edition', 'price', 'binding']);
    }
}
