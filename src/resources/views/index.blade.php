@extends('layouts.app')

@section('title')
    <title>商品一覧</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header-on')
    <div class="d-flex">
        @if(Auth::check())
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
<h2>商品一覧</h2>
@endsection
