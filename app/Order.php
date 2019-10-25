<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $apends = ['status_type'];

    public function products(){
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')->withPivot(['ordered_quantity']);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function getPaymentAttribute(){
        if($this->payment_method == 1){
            return 'Cash on Delivery';
        }else if($this->payment_method == 2){
            return 'Paypal';
        }
    }

    public function getStatusTypeAttribute(){
        if($this->status == 1){
            return 'Delivered';
        }else if($this->status == 2){
            return 'Shipped';
        }else if($this->status = 3){
            return 'Processing';
        }else{
            return 'Unpaid';
        }
    }

}
