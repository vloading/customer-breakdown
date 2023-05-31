<?php

namespace App\Http\Controllers;

use App\Models\OrderSource;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderSourceController extends Controller
{
    public function view(){
        
        $orderDetails = OrderDetails::where('channel', 'like', '329%')->get();

        $orderSource = OrderSource::whereIn('id', $orderDetails->pluck('id')->toArray())->get();
        return view('page.source', ['ordersource' => $orderSource]);
    }
}