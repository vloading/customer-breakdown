@extends('layouts.layout')
@section('title', 'Order Source')

@section('content')
    <h1>Order Source</h1>
    <table id="order">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Order List ID</th>
                <th>Order Status ID</th>
                <th>Is Approved</th>
                <th>Is Original</th>
                <th>Original Order Source ID</th>
                <th>Is Active</th>
                <th>Vendor Main ID</th>
                <th>Transfer Vendor ID</th>
                <th>Store Location ID</th>
                <th>Vendor Account Number</th>
                <th>DC</th>
                <th>Quantity</th>
                <th>Item Cost</th>
                <th>Vendor Selling Price</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Missing Data</th>
                <th>JSON Attributes</th>
                <th>Sales Agent</th>
                <th>Confirmed At</th>
                <th>Delivery Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ordersource as $item)
                <tr>
                    <td></td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->order_list_id }}</td>
                    <td>{{ $item->order_status_id }}</td>
                    <td>{{ $item->is_approved }}</td>
                    <td>{{ $item->is_original }}</td>
                    <td>{{ $item->original_order_source_id }}</td>
                    <td>{{ $item->is_active }}</td>
                    <td>{{ $item->vendor_main_id }}</td>
                    <td>{{ $item->transfer_vendor_id }}</td>
                    <td>{{ $item->store_location_id }}</td>
                    <td>{{ $item->vendor_account_number }}</td>
                    <td>{{ $item->dc }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->item_cost }}</td>
                    <td>{{ $item->vendor_selling_price }}</td>
                    <td>{{ $item->invoice_number }}</td>
                    <td>{{ $item->invoice_date }}</td>
                    <td>{{ $item->missing_data }}</td>
                    <td>{{ $item->json_attributes }}</td>
                    <td>{{ $item->sales_agent }}</td>
                    <td>{{ $item->confirmed_at }}</td>
                    <td>{{ $item->delivery_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('script')
    <script src="{{ asset('js/datatables/datatable.js') }}"></script>
@endpush
