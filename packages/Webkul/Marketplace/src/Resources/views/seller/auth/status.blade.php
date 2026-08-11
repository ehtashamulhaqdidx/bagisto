@extends('marketplace::layouts.seller')

@section('page_title', 'Account Status')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-lg shadow p-8 text-center">
    @if ($seller->status === 'pending')
        <h1 class="text-xl font-semibold mb-2">Application Pending</h1>
        <p class="text-gray-600">Your seller account is awaiting admin approval. You'll be notified once it's reviewed.</p>
    @elseif ($seller->status === 'disapproved')
        <h1 class="text-xl font-semibold mb-2">Application Not Approved</h1>
        <p class="text-gray-600">Your seller application was not approved. Contact support for details.</p>
    @elseif ($seller->status === 'suspended')
        <h1 class="text-xl font-semibold mb-2">Account Suspended</h1>
        <p class="text-gray-600">Your seller account has been suspended. Contact support for details.</p>
    @else
        <p>Your account is approved — <a href="{{ route('marketplace.seller.dashboard') }}" class="underline">go to your dashboard</a>.</p>
    @endif

    <form action="{{ route('marketplace.seller.logout') }}" method="POST" class="mt-6">
        @csrf
        <button type="submit" class="text-sm underline">Logout</button>
    </form>
</div>
@endsection
