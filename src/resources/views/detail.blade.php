@extends('layouts.app')

@section('title')
    <title>商品詳細</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('header-on')
    <div class="d-flex">
        @if (Auth::check())
            <form action="/logout" method="post">
                @csrf
                <button class="btn btn-secondary">ログアウト</button>
            </form>
        @else
            <a class="btn btn-secondary" href="/login">ログイン</a>
        @endif
        <a class="btn btn-secondary" href="/mypage">マイページ</a>
        <a class="btn btn-secondary" href="/sell">出品</a>
    </div>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="border p-3">
                    <img src="{{ asset('storage/' . $item->item_image_path) }}" class="img-fluid w-100"
                        alt="{{ $item->product_name }}">
                </div>
            </div>

            <div class="col-md-6">
                <h2>{{ $item->product_name }}</h2>
                <p class="text-muted">{{ $item->product_brand }}</p>
                <h4 class="text-danger">￥{{ number_format($item->product_price) }}（税込）</h4>

                <div class="d-flex align-items-center mb-3">
                    @if (Auth::check())
                        @if ($isFavorite)
                            <form action="{{route('favorite.destroy'), ['item_id'=>$item->id]}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="me-3">★</button>
                            </form>
                        @else
                            <form action="/item/{item_id}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <button type="submit" class="me-3">☆</button>
                            </form>
                        @endif
                    @else
                        <a href="/login" class=""><span class="me-3 ">★</span></a>
                    @endif
                    <span>○ 1</span>
                </div>

                <a href="#" class="btn btn-danger w-100">購入手続きへ</a>

                <div class="mt-4">
                    <h3>商品説明</h3>
                    <p>{{ $item->product_detail }}</p>
                </div>

                <div class="mt-3">
                    <h3>商品の情報</h3>
                    <p><strong>カテゴリー:</strong> 洋服 / メンズ</p>
                    <p><strong>商品の状態:</strong> 良好</p>
                </div>

                <div class="mt-4">
                    <h3>コメント (2)</h3>
                    <div class="d-flex align-items-start p-3">
                        <img src="storage/app/public/images/user-avatar.jpg" class="rounded-circle me-3" width="40"
                            height="40" alt="admin">
                        <div>
                            <h5 class="mb-1">admin</h5>
                            <p class="mb-0">こちらにコメントが入ります。</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start p-3">
                        <img src="storage/app/public/images/user-avatar.jpg" class="rounded-circle me-3" width="40"
                            height="40" alt="admin">
                        <div>
                            <h5 class="mb-1">admin</h5>
                            <p class="mb-0">こちらにコメントが入ります。</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h3>商品へのコメント</h3>
                    <form action="">
                        <textarea name="comment" class="form-control" rows="3"></textarea>
                        <button class="btn btn-danger w-100 mt-2">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
