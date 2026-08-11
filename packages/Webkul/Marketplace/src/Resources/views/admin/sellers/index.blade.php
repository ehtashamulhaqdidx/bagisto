@extends('admin::layouts.master')

@section('content')
    <div class="content">
        <h1>Sellers</h1>
        <a href="{{ route('admin.marketplace.sellers.create') }}" class="btn btn-primary">Create Seller</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Approved</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sellers as $seller)
                    <tr>
                        <td>{{ $seller->id }}</td>
                        <td>{{ $seller->customer_id }}</td>
                        <td>{{ $seller->status }}</td>
                        <td>{{ $seller->is_approved ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('admin.marketplace.sellers.edit', $seller->id) }}">Edit</a>

                            @if (! $seller->is_approved)
                                <form method="POST" action="{{ route('admin.marketplace.sellers.approve', $seller->id) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
