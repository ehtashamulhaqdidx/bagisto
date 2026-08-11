@extends('admin::layouts.master')

@section('page_title', 'Marketplace Payouts')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <h1 class="text-2xl font-semibold mb-6">Payout Requests</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-3">Seller</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Requested</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payouts as $payout)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $payout->seller->shop_title ?? '—' }}</td>
                        <td class="px-4 py-3">{{ number_format($payout->amount, 2) }}</td>
                        <td class="px-4 py-3">{{ ucfirst($payout->status) }}</td>
                        <td class="px-4 py-3">{{ $payout->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 space-x-2">
                            @if ($payout->status === 'requested')
                                <form action="{{ route('marketplace.admin.payouts.approve', $payout->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="underline text-green-700">Approve</button>
                                </form>
                                <form action="{{ route('marketplace.admin.payouts.reject', $payout->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="underline text-red-700">Reject</button>
                                </form>
                            @elseif ($payout->status === 'approved')
                                <form action="{{ route('marketplace.admin.payouts.mark-paid', $payout->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="underline">Mark Paid</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No payout requests.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $payouts->links() }}</div>
</div>
@endsection
