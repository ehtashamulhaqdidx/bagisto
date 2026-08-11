@extends('shop::layouts.master')

@section('content')
    <div class="content">
        <h1>{{ __('marketplace::messages.seller.create') }}</h1>

        <form method="POST" action="{{ route('marketplace.seller.request.store') }}">
            @csrf

            <div class="form-group">
                <label for="shop_title">Shop Name</label>
                <input type="text" name="shop_title" id="shop_title" class="control" />
            </div>

            <div class="form-group">
                <label for="shop_description">Shop Description</label>
                <textarea name="shop_description" id="shop_description" class="control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('marketplace::messages.seller.create') }}</button>
        </form>
    </div>
@endsection
