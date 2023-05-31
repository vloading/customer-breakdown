<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonthController extends Controller
{
    public function viewMonth()
    {
        return view('page.month');
    }
}

 // $data = DB::table('test')
        //     ->where('channel', 'like', '329%')
        //     ->whereYear('ordered_at', '=', $year)
        //     ->whereMonth('ordered_at', '=', $month)
        //     ->whereBetween('ordered_at', [$startDate, $endDate])
        //     ->select('first_name', 'quantity', 'selling_price')
        //     ->get();