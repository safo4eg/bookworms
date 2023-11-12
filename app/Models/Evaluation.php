<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'evaluations';
    protected $primaryKey = 'id';

    public function evaluationable()
    {
        return $this->morphTo();
    }
}
