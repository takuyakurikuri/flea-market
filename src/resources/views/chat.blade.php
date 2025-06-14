@extends('layouts.app')

@section('title')
    <title>取引チャット</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('header-on')
@endsection

@section('content')
<aside>
    <h3>その他の取引</h3>
    @foreach ($listItems as $listItem)
        @php
            $relatedPurchase = $listItem->purchases->firstWhere('user_id', $user->id)
                ?? $listItem->purchases->first();
        @endphp
        <div class="col">
            <a href="{{ route('chat.show', ['purchase' => $relatedPurchase->id]) }}" class="">
                <p class="">{{ $listItem->name }}</p>
            </a>
        </div>
    @endforeach
</aside>
<div class="container">
    <h2>{{$partner->name . 'さんとの取引'}}</h2>
    <div>
        <img class="card-img-top p-2" src="{{ asset('storage/' . $item->image_path) }}" alt="{{$item->name}}">
        <p>{{$item->name}}</p>
        <p class="text-danger">￥{{ number_format($item->price) }}（税込）</p>
    </div>
    {{-- <div class="d-flex">
        @foreach ($chats as $chat)
        <div class="{{$chat->user->id === Auth::id() ? 'justify-content-end' : 'justify-content-start'}}">
            <form action="" method="post">
                @method('fetch')
                <input type="text" value="{{$chat->message}}">
                <button type="submit">編集</button>
            </form>
            <form action="" method="post">
                <input type="hidden" name="chat_id" value="{{$chat->id}}">
                <button type="submit">削除</button>
            </form>
        </div>
        @endforeach
    </div> --}}

    @foreach ($chats as $chat)
        <div class="d-flex {{ $chat->user->id === Auth::id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
            <img src="{{ asset('storage/' . $chat->user->image_path) }}" alt="画像なし" class="rounded-circle"
                width="100" height="100">
            <div class="p-2 rounded {{ $chat->user->id === Auth::id() ? 'bg-primary text-white' : 'bg-light' }}">
                <div>{{ $chat->user->name }}</div>

                @if ($chat->user->id === Auth::id())
                    <form action="" method="post" class="d-inline">
                        @csrf
                        @method('fetch')
                        <input type="text" name="message" value="{{ $chat->message }}">
                        <button type="submit" class="btn btn-sm btn-light">編集</button>
                    </form>

                    <form action="" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                        <button type="submit" class="btn btn-sm btn-danger">削除</button>
                    </form>

                @else
                    <p>{{ $chat->message }}</p>
                @endif
            </div>
        </div>
    @endforeach
    <form action="{{route('chat.send', ['purchase' => $purchase])}}" method="post">
        @csrf
        <input type="text" name="message">
        <button type="submit">送信</button>
    </form>
</div>
@endsection