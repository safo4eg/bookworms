<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'reviews';
    protected $primaryKey = 'id';

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function evaluations()
    {
        return $this->morphMany(Evaluation::class, 'evaluationable');
    }
}
