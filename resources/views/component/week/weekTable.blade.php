@extends('page.week')
@section('table')

    @if (count($names) > 0)
        <table id="summary" class="table">
            <tr>
                <h3>Summary for {{ Carbon\Carbon::parse($startDate)->format('F j') }} - {{ Carbon\Carbon::parse($endDate)->format('j, Y') }}</h3>
            </tr>
            <tr>
                <th>Total Quantity this Week</th>
                <th>Total Sales this Week</th>
                <th>Total Gross Profit this Week</th>
            </tr>
            <tr>
                <td>{{ number_format($qtyThisWeek) }}</td>
                <td>${{ number_format($salesThisWeek, 2) }}</td>
                <td>${{ number_format($gpThisWeek, 2) }}</td>
            </tr>

            <tr>
                <th>Month to Date</th>
                <th>Sales</th>
                <th>Cumulative Sales</th>
            </tr>
            @php
                 $cumulativeSum = 0;
            @endphp
            @foreach ($mtd as $date => $value)
                <tr>
                    @php
                        $cumulativeSum += $value['thisDaySales'];
                    @endphp
                    <td>{{ Carbon\Carbon::parse($date)->format('F j, Y') }}</td>
                    <td>${{ number_format($value['thisDaySales'], 2) }}</td>
                    <td>${{ number_format($cumulativeSum, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2">Total Sales:</td>
                <td><b>${{ number_format($mtdSales, 2) }}</b></td>
            </tr>

            <tr>
                <th>Average Gross Profit (3-Month Period)</th>
                <th>Projected Sales Quantity ({{ Carbon\Carbon::parse($startDate)->format('F Y') }})</th>
                <th>Projected Sales Revenue ({{ Carbon\Carbon::parse($startDate)->format('F Y') }})</th>
            </tr>
            <tr>
                <td>${{ number_format($aveGp, 2) }}</td>
                <td>{{ number_format($projQty, 2) }}</td>
                <td>${{ number_format($projSales, 2) }}</td>
            </tr>
        </table>

        <table id="week-report" class="mt-5">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Sales this Week</th>
                    <th>Gross Profit this Week</th>
                    <th>Total Amount this Week</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($names as $index => $item)
                    <tr>
                        <td>{{ $names[$index] }}</td>
                        <td>${{ number_format($info[$names[$index]]['customerSales'], 2) }}</td>
                        <td>
                            @if ($info[$names[$index]]['gross_profit'] == 0)
                                ${{ $info[$names[$index]]['gross_profit'] }}
                            @else
                                ${{ number_format($info[$names[$index]]['gross_profit'], 2) }}
                            @endif
                        </td>
                        <td>{{ $info[$names[$index]]['quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <td colspan="2"><b>${{ number_format($salesThisWeek, 2) }}</b></td>
                <td><b>${{ number_format($gpThisWeek, 2) }}</b></td>
                <td><b>{{ number_format($qtyThisWeek) }}</b></td>
            </tfoot>
        </table>

        {{-- If count is = 0 --}}
    @else
        <table id="week-report">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Sales this Week</th>
                    <th>Gross Profit this Week</th>
                    <th>Total Amount this Week</th>
                </tr>
            </thead>
            <tbody>
                <p>No data available</p>
            </tbody>
        </table>
    @endif

@endsection

@push('script')
    <script src="{{ asset('js/datatables/datatable.js') }}"></script>
@endpush
