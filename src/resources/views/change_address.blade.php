@extends('layouts.app')

@section('title')
    <title>配送先変更</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('change_address/purchase.css') }}">
@endsection

@section('content')
<div class="container">
        <h2 class="text-center my-4">住所の変更</h2>
        <form action="/purchase/address/{{$item->id}}" method="post" class="mx-auto" style="max-width: 500px;">
            @csrf
            <div class="mb-3">
                <label for="zipcode" class="form-label">郵便番号</label>
                <input type="text" name="zipcode" id="zipcode" class="form-control">
                @error('zipcode')
                    {{$message}}
                @enderror
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">住所</label>
                <input type="text" name="address" id="address" class="form-control">
                @error('address')
                    {{$message}}
                @enderror
            </div>
            <div class="mb-3">
                <label for="building" class="form-label">建物名</label>
                <input type="text" name="building" id="building" class="form-control">
            </div>
            <button type="submit" class="btn btn-danger w-100">更新する</button>
        </form>
    </div>
@endsection