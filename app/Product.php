<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'category_id', 'price', 'quantity', 'image', 'description'];

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
