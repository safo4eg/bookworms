<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Reply extends Model
{
    use HasFactory;
    use NodeTrait;

    protected $table = 'replies';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
