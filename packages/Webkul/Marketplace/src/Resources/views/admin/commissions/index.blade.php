@extends('admin::layouts.master')

@section('page_title', 'Marketplace Commissions')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <h1 class="text-2xl font-semibold mb-6">Commission Ledger</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-3">Seller</th>
                    <th class="px-4 py-3">Order #</th>
                    <th class="px-4 py-3">Item Total</th>
                    <th class="px-4 py-3">Rate %</th>
                    <th class="px-4 py-3">Admin Earning</th>
                    <th class="px-4 py-3">Seller Earning</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($commissions as $commission)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $commission->seller->shop_title ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $commission->order_id }}</td>
                        <td class="px-4 py-3">{{ number_format($commission->item_total, 2) }}</td>
                        <td class="px-4 py-3">{{ $commission->commission_rate }}</td>
                        <td class="px-4 py-3">{{ number_format($commission->commission_amount, 2) }}</td>
                        <td class="px-4 py-3">{{ number_format($commission->seller_earning, 2) }}</td>
                        <td class="px-4 py-3">{{ ucfirst($commission->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No commissions recorded yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $commissions->links() }}</div>
</div>
@endsection
