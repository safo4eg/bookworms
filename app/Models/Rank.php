<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ranks';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
