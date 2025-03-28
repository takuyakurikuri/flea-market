@extends('layouts.app')

@section('title')
    <title>マイプロフィール</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
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
    <div class="container mt-4">
        <div class="d-flex justify-content-center align-items-center gap-3">
            <img src="{{ asset('storage/' . $user->profile->user_image_path) }}" alt="画像なし" class="rounded-circle"
                width="100" height="100">
            <h2 class="user-name mb-0">{{ $user->name }}</h2>
            <pre>     </pre>
            <a href="/mypage/profile" class="btn btn-outline-danger">プロフィールを編集</a>
        </div>

        <div class="d-flex border-bottom pb-2">
            <form action="/mypage" method="get" name="tab" value="sell" class="me-3">
                <input type="hidden" name="tab" value="sell">
                <button class="btn btn-link text-decoration-none">出品した商品</button>
            </form>
            <form action="/mypage" method="get">
                <input type="hidden" name="tab" value="buy">
                <button class="btn btn-link text-decoration-none text-danger">購入した商品</button>
            </form>
        </div>

        <div class="row row-cols-2 row-cols-md-4 g-3 mt-3">
            @foreach ($items as $item)
                <div class="col">
                    <a href="/item/{{$item->id}}" class="text-decoration-none text-dark">
                        <div class="card">
                            <img class="card-img-top p-2" src="{{ asset('storage/' . $item->item_image_path) }}"
                                alt="{{ $item->item_name }}">
                            <div class="card-body text-center">
                                <p class="card-text">{{ $item->item_name }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
