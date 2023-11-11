<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'genres';
    protected $primaryKey = 'id';

    public function books()
    {
        return $this->belongsToMany(
            Book::class,
            'book_genre',
            'genre_id',
            'book_id'
        );
    }
}
