@extends('marketplace::layouts.seller')

@section('page_title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Welcome back, {{ $seller->shop_title }}</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Products</p>
        <p class="text-2xl font-semibold">{{ $stats['total_products'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Orders</p>
        <p class="text-2xl font-semibold">{{ $stats['total_orders'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Total Sales</p>
        <p class="text-2xl font-semibold">{{ number_format($stats['total_sales'], 2) }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <p class="text-sm text-gray-500">Available Balance</p>
        <p class="text-2xl font-semibold">{{ number_format($stats['available_balance'], 2) }}</p>
    </div>
</div>

<div class="flex gap-4">
    <a href="{{ route('marketplace.seller.products.create') }}" class="bg-gray-900 text-white rounded px-4 py-2 text-sm">Add Product</a>
    <a href="{{ route('marketplace.seller.orders.index') }}" class="bg-white border rounded px-4 py-2 text-sm">View Orders</a>
    <a href="{{ route('marketplace.seller.payouts.index') }}" class="bg-white border rounded px-4 py-2 text-sm">Request Payout</a>
</div>
@endsection
