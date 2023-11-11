<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AuthorBook extends Pivot
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'author_book';
    protected $primaryKey = 'id';
}
