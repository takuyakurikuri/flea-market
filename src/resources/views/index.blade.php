@extends('layouts.app')

@section('title')
    <title>商品一覧</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection


@section('content')

<div class="container mt-4">
        <div class="d-flex border-bottom pb-2">
            <form action="/" method="get" class="me-3">
                <input type="hidden" value="">
                <button class="btn btn-link text-decoration-none">おすすめ</button>
            </form>
            <form action="{{ request('keyword') ? '/search' : '/' }}" method="get">
                <input type="hidden" name="tab" value="mylist">
                @if(Auth::check())
                    <button class="btn btn-link text-decoration-none text-danger">マイリスト</button>
                    <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                @else
                    <a class="btn btn-link text-decoration-none text-danger" href="/login">マイリスト</a>
                @endif
            </form>
        </div>

        <h2 class="mt-3">商品一覧</h2>
        <div class="d-flex flex-wrap">
            @foreach ($items as $item)
                <a href="/item/{{$item->id}}" class="text-decoration-none text-dark">
                    <div class="card m-2 item-card" style="width: 200px;">
                        <div class="image-container d-flex align-items-center justify-content-center">
                            <img class="card-img-top p-2" src="{{ asset('storage/' . $item->image_path) }}" alt="{{$item->name}}">
                            @if ($item->purchases->isNotEmpty())
                                <img class="soldout-overlay" src="{{ asset('images/soldout.png') }}" alt="soldout">
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <p class="card-text">{{$item->name}}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

{{--@if (/*おすすめ*/)
    @foreach ($items as $item)
        <div>
            <img src="{{$item['product_image']}}" alt="">
            <p>{{$item['item_name']}}</p>
        </div>
    @endforeach
@else /*マイリスト*/
        @foreach ($items as $item)
            <div>
                <img src="{{$item['product_image']}}" alt="">
                <p>{{$item['item_name']}}</p>
            </div>
    @endforeach
@endif--}}
@endsection
