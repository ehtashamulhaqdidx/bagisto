@extends('admin::layouts.master')

@section('content')
    <div class="content">
        <h1>Edit Seller</h1>

        <form method="POST" action="{{ route('admin.marketplace.sellers.update', $seller->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="customer_id">Customer ID</label>
                <input type="text" name="customer_id" id="customer_id" value="{{ $seller->customer_id }}" class="control" />
            </div>
            <div class="form-group">
                <label for="commission_rate">Commission Rate</label>
                <input type="text" name="commission_rate" id="commission_rate" value="{{ $seller->commission_rate }}" class="control" />
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
