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
<p>メールを送信しました</p>
<form action="/email/verification-notification" method="post">
    @csrf
    <button>メールの再送</button>
</form>
@endsection