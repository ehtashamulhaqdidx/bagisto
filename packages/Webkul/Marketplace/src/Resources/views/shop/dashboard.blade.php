@extends('shop::layouts.master')

@section('content')
    <div class="content">
        <h1>Seller Dashboard</h1>

        @if ($seller)
            <p>ID: {{ $seller->id }}</p>
            <p>Status: {{ $seller->status }}</p>
        @else
            <p>No seller found.</p>
        @endif
    </div>
@endsection
