@extends('layouts.app')

@section('title')
    <title>会員登録</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('header-on')
        <a class="register__button-submit btn btn-outline-primary rounded-0" href="/login">ログインはこちらから</a>
@endsection

@section('content')
<h2>会員登録</h2>
<form action="/register" method="post">
    @csrf
    <div>
        <label for="">ユーザー名</label>
        <input type="text" name="name" id="">
    </div>
    <div>
        <label for="">メールアドレス</label>
        <input type="text" name="email" id="">
    </div>
    <div>
        <label for="">パスワード</label>
        <input type="password" name="password" id="">
    </div>
    <div>
        <label for="">確認用パスワード</label>
        <input type="password" name="password_confirmation" id="">
    </div>
    <button type="submit">登録</button>
</form>
@endsection
