@extends('marketplace::layouts.seller')

@section('page_title', 'Orders')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Orders</h1>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-3">Order #</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $order->increment_id ?? $order->id }}</td>
                    <td class="px-4 py-3">{{ $order->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">{{ ucfirst($order->status) }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('marketplace.seller.orders.show', $order->id) }}" class="underline">View</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No orders yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $orders->links() }}</div>
@endsection
