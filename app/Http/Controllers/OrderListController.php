<?php

namespace App\Http\Controllers;
use App\Models\OrderDetails;
use App\Models\OrderList;

class OrderListController extends Controller
{
    // public function view(){
    //     $orderlist = DB::table('orderlist')->get();
    //     return view('page.list', ['orderlist' => $orderlist]);
    // }

    public function view()
    {

        // $orderDetails = OrderDetails::where('channel', 'like', '329%')->get();

        // $orderList = OrderList::whereIn('id', $orderDetails->pluck('id')->toArray())->get();
        $orderList = OrderList::join('orderdetails', 'orderlist.id', '=', 'orderdetails.order_list_id')
        ->where('orderdetails.channel', 'like', '329%')
        ->get();

        dd($orderList[0]);
        
        return view('page.list', ['orderlist' => $orderList]);
    }
}