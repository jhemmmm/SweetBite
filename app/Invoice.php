<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model{

    public function order(){
        return $this->belongsTo(Order::class);
    }

    /**
     * Status
     *  0 = not process
     * 1 = paid
     * 2 = refund
     * 3 = cancelled
     */

}
