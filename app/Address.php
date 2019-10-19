<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
        'name', 'user_id', 'mobile_number', 'house_number', 'barangay', 'province', 'city'
    ];

    protected $appends = ['full_address'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute(){
        return $this->house_number . ' ' . $this->barangay . ', ' .$this->city . ', ' . $this->province;
    }
}
