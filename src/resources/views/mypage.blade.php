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
            <img src="{{ asset('storage/' . $user->image_path) }}" alt="画像なし" class="rounded-circle"
                width="100" height="100">
            <div>
                <h2 class="user-name mb-0">{{ $user->name }}</h2>
                @php
                    $rounded = round($avgRating);
                @endphp

                <div class="star-display">
                    @for ($i = 1; $i <= 5; $i++)
                        <span style="color: {{ $i <= $rounded ? '#f5b301' : '#ccc' }}; font-size: 1.5rem;">★</span>
                    @endfor
                </div>
            </div>
            <pre>     </pre>
            <a href="/mypage/profile" class="btn btn-outline-danger">プロフィールを編集</a>
        </div>

        <div class="d-flex border-bottom pb-2">
            <form action="/mypage" method="get" name="tab" value="sell" class="">
                <input type="hidden" name="tab" value="sell">
                <button class="btn btn-link text-decoration-none {{ request('tab') === 'sell' ? 'text-danger' : '' }}">出品した商品</button>
            </form>
            <form action="/mypage" method="get">
                <input type="hidden" name="tab" value="buy">
                <button class="btn btn-link text-decoration-none {{ request('tab') === 'buy' ? 'text-danger' : '' }}">購入した商品</button>
            </form>
            <form action="/mypage" method="get">
                <input type="hidden" name="tab" value="trading">
                <button class="btn btn-link text-decoration-none {{ request('tab') === 'trading' ? 'text-danger' : '' }}">
                    取引中の商品
                    @if ($totalUnreadCount > 0)
                        <span class="badge bg-danger">{{ $totalUnreadCount }}</span>
                    @endif
                </button>
            </form>
        </div>

        <div class="row row-cols-2 row-cols-md-4 g-3 mt-3">
            @if (request('tab') == 'trading')
                @foreach ($items as $item)
                    @php
                        $relatedPurchase = $item->purchases->firstWhere('user_id', $user->id)
                            ?? $item->purchases->first();
                    @endphp
                    <div class="col">
                        <a href="{{ route('chat.show', ['purchase' => $relatedPurchase->id]) }}" class="text-decoration-none text-dark">
                            <div class="card">
                                <img class="card-img-top p-2" src="{{ asset('storage/' . $item->image_path) }}"
                                    alt="{{ $item->name }}">
                                <div class="card-body text-center">
                                    <p class="card-text">{{ $item->name }}</p>
                                </div>
                                {{-- 未読メッセージ数を表示 --}}
                                @if (!empty($relatedPurchase->unread_count) && $relatedPurchase->unread_count > 0)
                                    <span class="position-absolute top-0 start-10 translate-middle badge rounded-pill bg-danger">
                                        {{ $relatedPurchase->unread_count }}
                                    </span>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                @foreach ($items as $item)
                    <div class="col">
                        <a href="/item/{{$item->id}}" class="text-decoration-none text-dark">
                            <div class="card">
                                <img class="card-img-top p-2" src="{{ asset('storage/' . $item->image_path) }}"
                                    alt="{{ $item->name }}">
                                @if ($item->purchases->isNotEmpty())
                                    <img class="soldout-overlay" src="{{ asset('images/soldout.png') }}" alt="soldout">
                                @endif
                                <div class="card-body text-center">
                                    <p class="card-text">{{ $item->name }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
            
        </div>
    </div>
@endsection
