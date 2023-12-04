<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;
    protected $guarded = [];
    protected $primaryKey = 'id';

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getIsModerAttribute()
    {
        return ($this->role->title === 'Модератор')? true: false;
    }

    public function changeRank()
    {
        $rank = Rank::class;
        if($this->points >= 0 AND $this->points < 100) {
            $rank::where('title', 'Новичок')->first();
        } else if($this->points >= 100 AND $this->points < 500) {
            $rank::where('title', 'Знаток')->first();
        } else if($this->points >= 500 AND $this->points < 1000) {
            $rank::where('title', 'Профи')->first();
        } else if($this->points >= 1000 AND $this->points < 2500) {
            $rank::where('title', 'Мудрец')->first();
        } else if($this->points >= 2500 AND $this->points < 5000) {
            $rank::where('title', 'Вассерман')->first();
        }

        User::withoutEvents(function () use($rank) {
            $this->update(['rank_id' => $rank->id]);
        });
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    public function critiques()
    {
        return $this->hasMany(Critique::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
