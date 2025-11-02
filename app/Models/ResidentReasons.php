<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResidentReasons extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'resident_id',
        'reason_id',
    ];
}
