<?php

namespace App\Http\Controllers;

use App\Models\OrderList;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function viewWeek(Request $request)
    {
        // * From Database
        $months = DB::table('months')->get()->toArray();
        $weeks = DB::table('week_number')->get()->toArray();
        $years = DB::table('years')->get()->toArray();

        // * Select from Blade
        $month = $request->input('month');
        $weekNumber = $request->input('week_number');
        $year = $request->input('year');

        // *  Get 3 Previous Months
        $startMonth = Carbon::create($year, $month)->subMonths(3)->startOfMonth();
        $endMonth = Carbon::create($year, $month)->subMonths(0)->endOfMonth();

        // * All the months before
        $beforeMonths = Carbon::create($year, $month)->subMonths(0)->startOfMonth();

        // * Get days of the month
        $firstDay = Carbon::create($year, $month)->startOfMonth();
        $lastDay = Carbon::create($year, $month)->endOfMonth();

        // * Get Week
        $startDate = Carbon::create($year, $month, $weekNumber);
        if ($weekNumber == '29') {
            $endDate = $lastDay;
        } else {
            $endDate = Carbon::create($year, $month, $weekNumber + 6)->endOfDay();
        }

        // * Per Customer
        $customerSales = 0;
        $names = [];
        $info = [];

        // * Total
        $totalSales = 0;
        $totalQuantity = 0;
        $totalGp = 0;

        // * Summary
        $gpThisWeek = 0;
        $salesThisWeek = 0;
        $qtyThisWeek = 0;
        $mtd = [];
        $mtdSales = 0;
        $thisDaySales = 0;
        $daySales = 0;
        $projectedMonths = [];
        $lastMonths = [];
        $percentages = [];
        $percentageQty = [];
        $projQty = 0;
        $projSales = 0;

        // * Collect data and combine orderdetails to orderlist
        $orderList = OrderList::join('orderdetails', 'orderlist.id', '=', 'orderdetails.order_list_id')
            ->where('orderdetails.channel', 'like', '329%')
            ->whereYear('ordered_at', '=', $year)
            ->whereMonth('ordered_at', '=', $month)
            ->whereBetween('ordered_at', [$startDate, $endDate])
            ->select('first_name', 'quantity', 'selling_price', 'gross_profit')
            ->get();

        // * Get data from Previous Months (3 mos)
        $previousMonths = OrderDetails::query()
            ->where('orderdetails.channel', 'like', '329%')
            ->whereBetween('ordered_at', [$startMonth, $endMonth])
            ->select('first_name', 'quantity', 'selling_price', 'gross_profit', 'ordered_at')
            ->get();

        // * Get data for each day
        $days = OrderDetails::query()
            ->where('orderdetails.channel', 'like', '329%')
            ->whereBetween('ordered_at', [$firstDay, $endDate])
            ->select('quantity', 'selling_price', 'ordered_at')
            ->get();

        $projectedValues = OrderDetails::query()
            ->where('orderdetails.channel', 'like', '329%')
            ->where('ordered_at', '<', $beforeMonths)
            ->distinct('ordered_at')
            ->select('quantity', 'selling_price', 'ordered_at')
            ->get();

        foreach ($days as $day) {
            $qty = intval($day->quantity);
            $price = floatval($day->selling_price);
            $date = substr($day->ordered_at, 0, 10);

            if (!isset($mtd[$date])) {
                $daySales = $qty * $price;
                $thisDaySales += $daySales;
                $mtdSales += $daySales;
                $mtd[$date] = [
                    'ordered_at' => $date,
                    'thisDaySales' => $thisDaySales,
                ];
            } else {
                $daySales = $qty * $price;
                $thisDaySales += $daySales;
                $mtdSales += $thisDaySales;
                $mtd[$date]['thisDaySales'] += $daySales;
            }
            $thisDaySales = 0;
        }

        ksort($mtd);

        // * Collect data from previous months
        foreach ($previousMonths as $prev) {
            $qty = intval($prev->quantity);
            $gp = floatval($prev->gross_profit);
            $price = floatval($prev->selling_price);
            $date = Carbon::parse($prev->ordered_at)->format('Y-m');

            $totalGp += $gp;
            $totalSales += $qty * $price;
            $totalQuantity += $qty;
        }

        // * Collect data from previous months
        foreach ($projectedValues as $prev) {
            $qty = intval($prev->quantity);
            $price = floatval($prev->selling_price);
            $date = Carbon::parse($prev->ordered_at)->format('Y-m');

            if (!isset($projectedMonths[$date])) {
                $projectedMonths[$date] = [
                    'thisMonthQty' => $qty,
                    'thisMonthSales' => $qty * $price,
                ];
            } else {
                $projectedMonths[$date]['thisMonthQty'] += $qty;
                $projectedMonths[$date]['thisMonthSales'] += $qty * $price;
            }
        }

        foreach ($projectedMonths as $innerArray) {
            $lastMonths[] = $innerArray;
        }
        
        $keys = array_keys($lastMonths);
      
        // * Correct way add [] to store the % or difference
        $checker = 0;
        $lastSale = 0;
        $lastQty = 0;
        for ($i = 0; $i < count($keys) - 1; $i++) {
            $currentKey = $keys[$i];
            $nextKey = $keys[$i+1];
        
            $percentageQty[] = ($lastMonths[$nextKey]['thisMonthQty'] - $lastMonths[$currentKey]['thisMonthQty']) / abs($lastMonths[$currentKey]['thisMonthQty']) * 100;
            
            $percentages[] = ($lastMonths[$nextKey]['thisMonthSales'] - $lastMonths[$currentKey]['thisMonthSales']) / abs($lastMonths[$currentKey]['thisMonthSales']) * 100;
            if($checker == count($keys) - 2){
                $lastQty = $lastMonths[$nextKey]['thisMonthQty'];
                $lastSale = $lastMonths[$nextKey]['thisMonthSales'];
            }
            $checker++;
        }
        
        // ? Expected Output 3,013,078.9 Dec 1 2021
        $percentageSum = array_sum($percentages) / count($percentages);
        $percentageQuantity = array_sum($percentageQty) / count($percentageQty);
        
        $formattedSales = number_format($percentageSum / 100, 2);
        $formattedQty = number_format($percentageQuantity / 100, 2);

        //dd($formattedQty);
        
        $projSales = $lastSale * (1 + $formattedSales);
        $projQty = $lastQty * (1 + $formattedQty);
        
        // ? Expected Output 3,013,078.9 / 6,447.98 Dec 1 2021
        
        // ? Expected Output if 749 523.33 * 1.06 = 794,494.7298 Dec 1 2021
        // 0 => -26.431460852474
        // 1 => 12.323979283599
        // 2 => 11.522806549656
        // 3 => 25.168421853516

        $aveGp = $totalGp / 3;

        // * Store data for each Customer
        foreach ($orderList as $row) {
            $name = $row->first_name;
            $quantity = intval($row->quantity);
            $sellingPrice = floatval($row->selling_price);
            $grossProfit = floatval($row->gross_profit);

            if (!in_array($name, $names)) {
                $customerSales += $quantity * $sellingPrice;
                $qtyThisWeek += $quantity;
                $gpThisWeek += $grossProfit;
                $salesThisWeek += $customerSales;
                $info[$name] = [
                    'name' => $name,
                    'customerSales' => $customerSales,
                    'quantity' => $quantity,
                    'gross_profit' =>  $grossProfit
                ];
                $names[] = $name;
                $customerSales = 0;
            } else {
                $customerSales += $quantity * $sellingPrice;
                $qtyThisWeek += $quantity;
                $gpThisWeek += $grossProfit;
                $salesThisWeek += $customerSales;
                $info[$name]['customerSales'] += $salesThisWeek;
                $info[$name]['quantity'] += $quantity;
                $info[$name]['gross_profit'] += $grossProfit;
                $customerSales = 0;
            }
        }

        // * Default Month
        if ($month == null || $weekNumber == null || $year == null) {
            $selectedMonth = 1;
            $selectedWeekNumber = 1;
            $selectedYear = 2020;
        } else {
            $selectedMonth = $month;
            $selectedWeekNumber = $weekNumber;
            $selectedYear = $year;
        }

        return view('component.week.weekTable', [
            'order_detail' => $orderList,
            'endDate' => $endDate,
            'startDate' => $startDate,

            'months' => $months,
            'week_number' => $weeks,
            'years' => $years,
            'selectedMonth' => $selectedMonth,
            'selectedWeekNumber' => $selectedWeekNumber,
            'selectedYear' => $selectedYear,
            'names' => $names,
            'info' => $info,

            // * Total this Week
            'salesThisWeek' => $salesThisWeek,
            'qtyThisWeek' => $qtyThisWeek,
            'gpThisWeek' => $gpThisWeek,
            'mtd' => $mtd,
            'mtdSales' => $mtdSales,
            'aveGp' => $aveGp,
            'projSales' => $projSales,
            'projQty' => $projQty,
        ]);
    }
}


// ! vload1ng vloading0