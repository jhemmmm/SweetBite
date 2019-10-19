<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $apends = ['status_type'];

    public function product(){
        return $this->belongsToMany(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getStatusTypeAttribute(){
        if($this->status == 1){
            return 'Paid';
        }else if($this->status == 2){
            return 'Refunded';
        }else{
            return 'Unpaid';
        }
    }

}
