<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Critique extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'critiques';
    protected $primaryKey = 'id';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getLikesAttribute()
    {
        return $this->evaluations()->whereHas('type', function ($query) {
            $query->where('title', 'like');
        })->count();
    }

    public function getDislikesAttribute()
    {
        return $this->evaluations()->whereHas('type', function ($query) {
            $query->where('title', 'dislike');
        })->count();
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
