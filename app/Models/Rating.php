<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'ratings';
    protected $primaryKey = 'id';

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
