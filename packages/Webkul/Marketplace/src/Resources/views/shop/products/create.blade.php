@extends('shop::layouts.master')

@section('content')
    <div class="content">
        <h1>Upload Product</h1>

        <form method="POST" action="{{ route('marketplace.seller.products.store') }}">
            @csrf

            <div class="form-group">
                <label for="product_id">Product ID</label>
                <input type="text" name="product_id" id="product_id" class="control" />
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="control">
                    <option value="pending">Pending</option>
                    <option value="active">Active</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
@endsection
