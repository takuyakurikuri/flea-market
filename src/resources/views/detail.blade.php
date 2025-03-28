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
                        alt="{{ $item->item_name }}">
                </div>
            </div>

            <div class="col-md-6">
                <h2>{{ $item->item_name }}</h2>
                <p class="text-muted">{{ $item->item_brand }}</p>
                <h4 class="text-danger">￥{{ number_format($item->item_price) }}（税込）</h4>

                <div class="d-flex align-items-center mb-3">
                    @if (Auth::check())
                        @if ($isFavorite)
                            <form action="/item/{item_id}" method="post">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <button type="submit" class="me-3 d-flex align-items-center favorite">
                                    <img class="icon me-1" src="{{ asset('images/togglestar.png') }}" alt="お気に入り解除する">
                                    {{ $item->favorites_count }}
                                </button>
                            </form>
                        @else
                            <form action="/item/{item_id}" method="post">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <button type="submit" class="me-3 d-flex align-items-center favorite">
                                    <img class="icon me-1" src="{{ asset('images/addstar.png') }}" alt="お気に入り登録する">
                                    {{ $item->favorites_count }}
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="/login" class="">
                            <span class="me-3 d-flex align-items-center">
                                <img class="icon me-1" src="{{ asset('images/addstar.png') }}" alt="会員登録をする">
                               {{ $item->favorites_count }}
                            </span>
                        </a>
                    @endif
                    <span class="d-flex align-items-center">
                        <img class="icon me-1" src="{{ asset('images/comment.png') }}" alt="コメント数">
                        {{$comments_count->comments_count}}
                    </span>
                </div>
                @if (isset($item->purchase_id))
                    <p class="btn btn-light w-100">売り切れました</p>
                @else
                    <a href="/item/{{$item->id}}/purchase" class="btn btn-danger w-100">購入手続きへ</a>
                @endif
                

                <div class="mt-4">
                    <h3>商品説明</h3>
                    <p>{{ $item->item_detail }}</p>
                </div>

                <div class="mt-3">
                    <h3>商品の情報</h3>
                    <p>
                        <strong class="fw-bold">カテゴリー</strong>
                        @foreach ($item_categories as $item_category)
                            <span class="badge rounded-pill bg-light text-dark border">
                                {{$item_category->category->content}} 
                            </span>
                        @endforeach
                    </p>
                    <p>
                        <strong>商品の状態 </strong>
                        {{--{{$item->condition->content}}--}}
                        @switch($item->condition)
                            @case(1)
                                良好
                                @break
                            @case(2)
                                目立った傷や汚れなし
                                @break
                            @case(3)
                                やや傷や汚れあり
                                @break
                            @case(4)
                                状態が悪い
                                @break
                            @default
                                情報なし
                        @endswitch
                    </p>
                </div>

                <div class="mt-4">
                    <h3>コメント ({{$comments_count->comments_count}})</h3>
                    
                    @foreach ($comments as $comment)
                        <div class="d-flex align-items-start p-3">
                            <img src="{{ asset('storage/' . $comment->user->profile->user_image_path) }}" class="rounded-circle me-3" width="40"
                                height="40" alt="admin">
                            <div>
                                <h5 class="mb-1">{{$comment->user->name}}</h5>
                                <p class="mb-0">{{$comment->content}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <h3>商品へのコメント</h3>
                    <form action="/item/{item_id}/comment" method="post">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input  type="text" name="comment" class="form-control" rows="3">
                        @error('content')
                            {{$message}}
                        @enderror
                        <button class="btn btn-danger w-100 mt-2">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
