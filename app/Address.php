<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
        'name', 'user_id', 'mobile_number', 'house_number', 'barangay', 'province', 'city'
    ];

    //
}
