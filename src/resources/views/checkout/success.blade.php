@extends('layouts.app')

@section('content')
<div class="container">
    <h2>決済が完了しました</h2>
    <p>ご購入いただきありがとうございます。</p>
    <a href="{{ url('/') }}" class="btn btn-primary">トップページへ戻る</a>
</div>
@endsection