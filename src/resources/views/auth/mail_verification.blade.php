@extends('layouts.app')

@section('title')
    <title>ユーザー登録確認</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('header-on')
@endsection

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="text-center">
        <p>登録していただいたメールアドレスに認証メールを送付しました。</p>
        <p>メール認証を完了してください。</p>
        <a href="http://localhost:8025/" class="btn btn-secondary my-3">認証はこちらから</a>
        <form action="/email/verification-notification" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{}}">
            <button class="btn btn-link text-primary">認証メールを再送する</button>
        </form>
    </div>
</div>
@endsection