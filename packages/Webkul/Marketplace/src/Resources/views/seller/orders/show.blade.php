@extends('marketplace::layouts.seller')

@section('page_title', 'Order Detail')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Order #{{ $order->increment_id ?? $order->id }}</h1>

{{-- Only this seller's items are shown, even if the order contains items
     belonging to other sellers. --}}
<div class="bg-white rounded-lg shadow overflow-hidden mb-6">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-3">Item</th>
                <th class="px-4 py-3">SKU</th>
                <th class="px-4 py-3">Qty</th>
                <th class="px-4 py-3">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $item->name }}</td>
                    <td class="px-4 py-3">{{ $item->sku }}</td>
                    <td class="px-4 py-3">{{ $item->qty_ordered }}</td>
                    <td class="px-4 py-3">{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="grid grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="font-semibold mb-3">Create Invoice</h2>
        <form method="POST" action="{{ route('marketplace.seller.orders.invoices.store', $order->id) }}">
            @csrf
            @foreach ($items as $item)
                <div class="flex justify-between items-center mb-2 text-sm">
                    <span>{{ $item->name }} ({{ $item->qty_ordered }} available)</span>
                    <input type="number" name="items[{{ $item->id }}]" min="0" max="{{ $item->qty_ordered }}"
                           value="{{ $item->qty_ordered }}" class="w-20 border rounded px-2 py-1">
                </div>
            @endforeach
            <button type="submit" class="mt-3 bg-gray-900 text-white rounded px-4 py-2 text-sm">Generate Invoice</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="font-semibold mb-3">Create Shipment</h2>
        <form method="POST" action="{{ route('marketplace.seller.orders.shipments.store', $order->id) }}">
            @csrf
            @foreach ($items as $item)
                <div class="flex justify-between items-center mb-2 text-sm">
                    <span>{{ $item->name }} ({{ $item->qty_ordered }} available)</span>
                    <input type="number" name="items[{{ $item->id }}]" min="0" max="{{ $item->qty_ordered }}"
                           value="{{ $item->qty_ordered }}" class="w-20 border rounded px-2 py-1">
                </div>
            @endforeach
            <button type="submit" class="mt-3 bg-gray-900 text-white rounded px-4 py-2 text-sm">Ship Items</button>
        </form>
    </div>
</div>
@endsection
