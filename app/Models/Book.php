<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = [
        'title',
        'description',
        'image',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_book', 'book_id', 'author_id');
    }
}
