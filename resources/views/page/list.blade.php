@extends('layouts.layout')
@section('title', 'Order List')

@section('content')
    <h1>Order List</h1>
    <table id="order">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Order Status</th>
                <th>PO Number</th>
                <th>System PO Number</th>
                <th>User ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderlist as $item)
                <tr>
                    <td></td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->order_status_id }}</td>
                    <td>{{ $item->po_number }}</td>
                    <td>{{ $item->system_po_number }}</td>
                    <td>{{ $item->user_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- <p>{{ $item->id }}</p> --}}
@endsection

@push('script')
    <script src="{{ asset('js/datatables/datatable.js') }}"></script>
@endpush
