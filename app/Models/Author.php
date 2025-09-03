<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    protected $table = 'authors';

    protected $fillable = [
        'last_name', 'first_name', 'middle_name',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'author_book', 'author_id', 'book_id');
    }
}
