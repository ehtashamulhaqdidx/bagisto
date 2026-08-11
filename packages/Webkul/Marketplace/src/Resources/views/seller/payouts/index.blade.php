@extends('marketplace::layouts.seller')

@section('page_title', 'Payouts')

@section('content')
<h1 class="text-2xl font-semibold mb-2">Payouts</h1>
<p class="text-gray-600 mb-6">Available balance: <strong>{{ number_format($available_balance, 2) }}</strong></p>

<div class="bg-white rounded-lg shadow p-6 mb-8 max-w-md">
    <h2 class="font-semibold mb-3">Request a Payout</h2>
    <form method="POST" action="{{ route('marketplace.seller.payouts.store') }}" class="space-y-3">
        @csrf
        <div>
            <label class="block text-sm mb-1">Amount</label>
            <input type="number" step="0.01" name="amount" max="{{ $available_balance }}" required
                   class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm mb-1">Payment Method (optional)</label>
            <input type="text" name="payment_method" placeholder="Bank transfer, PayPal, etc."
                   class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-gray-900 text-white rounded px-4 py-2 text-sm">Request Payout</button>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Amount</th>
                <th class="px-4 py-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payouts as $payout)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $payout->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">{{ number_format($payout->amount, 2) }}</td>
                    <td class="px-4 py-3">{{ ucfirst($payout->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-4 py-6 text-center text-gray-500">No payout requests yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $payouts->links() }}</div>
@endsection
