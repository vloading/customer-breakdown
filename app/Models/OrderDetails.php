<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table = 'orderdetails';

    public function getAllOrders()
    {
        //  return DB::table('orderdetails')
        //         ->where('channel', 'like', '329%')
        //         ->get();

        // $orderDetails = DB::table('orderdetails')
        //     ->where('channel', 'like', '329%')
        //     ->get();


        // return $orderDetails;

        return DB::table($this->table)->get();
    }
}