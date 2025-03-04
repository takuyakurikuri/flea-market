@extends('layouts.app')

@section('title')
    <title>プロフィール設定</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
<div class="container mt-5">
    <h2 class="mb-4">プロフィール設定</h2>
    <form action="/mypage/profile" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <div class="mb-3">
            <label for="profile_image_path" class="form-label">プロフィール画像</label>
            
            <!-- 画像プレビュー部分 -->
            <div class="d-flex align-items-center gap-3">
                <div id="imagePreview" class="rounded-circle border border-secondary" 
                    style="width: 80px; height: 80px; background-color: #ddd; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <img id="previewImg" {{--src="{{ $user->profile->user_image_path ? asset('storage/' . $user->profile->user_image_path) : '' }}"--}} alt="" style="width: 100%; height: 100%; object-fit: cover; {{--{{ $user->profile->user_image_path ? '' : 'display: none;' }}--}}">
                </div>

                <!-- ファイル選択ボタン -->
                <label for="profile_image_path" class="btn btn-outline-danger">画像を選択する</label>
                <input type="file" name="user_image_path" accept="image/*" class="form-control d-none" id="profile_image_path">
            </div>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">ユーザー名</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}">
        </div>
        <div class="mb-3">
            <label for="zipcode" class="form-label">郵便番号</label>
            <input type="text" name="zipcode" class="form-control" id="zipcode" value="{{ old('zipcode' {{--, $user->profile->zipcode--}}) }}">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">住所</label>
            <input type="text" name="address" class="form-control" id="address" value="{{ old('address' {{--, $user->profile->address--}}) }}">
        </div>
        <div class="mb-3">
            <label for="building" class="form-label">建物名</label>
            <input type="text" name="building" class="form-control" id="building" value="{{ old('building' {{--, $user->profile->building--}}) }}">
        </div>
        <button type="submit" class="btn btn-danger">更新する</button>
    </form>
</div>
@endsection