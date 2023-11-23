<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'reviews';
    protected $primaryKey = 'id';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function evaluations()
    {
        return $this->morphMany(Evaluation::class, 'evaluationable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

}
