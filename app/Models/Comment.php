<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'comments';
    protected $primaryKey = 'id';

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
    public function commentable()
    {
        return $this->morphTo();
    }
}
