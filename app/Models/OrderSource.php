<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderSource extends Model
{
    use HasFactory;

    protected $table = 'ordersource';

    public function getAllOrders()
    {
        return DB::table($this->table)->get();
        //return $this->hasOne(OrderDetails::class);
    }
    
}