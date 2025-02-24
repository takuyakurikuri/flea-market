@extends('layouts.app')

@section('title')
    <title>ログイン</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('header-on')
        <a class="register__button-submit btn btn-outline-primary rounded-0" href="/register">会員登録はこちらから</a>
@endsection

@section('content')
<h2>ログイン</h2>
<form action="/login" method="post">
    @csrf
    <div>
        <label for="">メールアドレス</label>
        <input type="text" name="email" id="">
    </div>
    <div>
        <label for="">パスワード</label>
        <input type="password" name="password" id="">
    </div>
    <button type="submit">ログイン</button>
</form>
@endsection
