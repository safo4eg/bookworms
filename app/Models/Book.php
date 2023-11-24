<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'books';
    protected $primaryKey = 'id';

    public function authors()
    {
        return $this->belongsToMany(
            Author::class,
            'author_book',
            'book_id',
            'author_id'
        );
    }

    public function genres()
    {
        return $this->belongsToMany(
            Genre::class,
            'book_genre',
            'book_id',
            'genre_id'
        );
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'book_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id', 'id');
    }

    public function critiques()
    {
        return $this->hasMany(Critique::class, 'book_id', 'id');
    }
}
