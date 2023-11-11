<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookGenre extends Pivot
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'book_genre';
    protected $primaryKey = 'id';
}
