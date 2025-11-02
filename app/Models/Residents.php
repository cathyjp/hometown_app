<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Residents extends Model
{
    protected $fillable = [
        'family_name',
        'first_name',
        'family_name_kana',
        'first_name_kana',
        'postal_code',
        'address_city',
        'address_detail',
        'phone',
        'gender',
        'birth_date',
        'email',
        'status',
        'is_deleted',
    ];
}
