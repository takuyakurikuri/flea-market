@extends('layouts.app')

@section('content')
<div class="container">
    <h2>決済がキャンセルされました</h2>
    <p>もう一度お試しください。</p>
    <a href="{{ url('/') }}" class="btn btn-primary">トップページへ戻る</a>
</div>
@endsection