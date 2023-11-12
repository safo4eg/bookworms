<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Critique extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'critiques';
    protected $primaryKey = 'id';

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
