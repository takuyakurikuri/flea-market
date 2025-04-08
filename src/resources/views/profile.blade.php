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
<div class="container main-content mt-5">
    <h2 class="text-center mb-4">プロフィール設定</h2>

    <form action="/mypage/profile" method="post" enctype="multipart/form-data" class="mx-auto col-md-6">
        @csrf
        @if ($user->address)
            @method('patch')
        @endif
        <input type="hidden" name="user_id" value="{{$user->id}}">

        <div class="text-center mb-3">
            <label for="profile_image_path" class="form-label">プロフィール画像</label>
            <div class="d-flex align-items-center justify-content-center">
                <div id="imagePreview" class="rounded-circle border border-secondary d-flex align-items-center justify-content-center"
                    style="width: 100px; height: 100px; background-color: #ddd; overflow: hidden;">
                    @php
                        $profileImagePath = $user->image_path;
                    @endphp
                    @if ($profileImagePath)
                        <img id="previewImg" src="{{ asset('storage/' . $profileImagePath) }}" alt="プロフィール画像"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <img id="previewImg" src="" alt="プロフィール画像"
                            style="width: 100%; height: 100%; object-fit: cover; display: none;">
                    @endif
                </div>
                <input type="hidden" name="existing_image_path" value="{{ $user->image_path }}">
                @error('image_path')
                    {{$message}}
                @enderror
                <label for="image_path" class="btn btn-outline-danger ms-5">画像を選択する</label>
                <input type="file" name="image_path" accept="image/*" class="form-control d-none" id="image_path">
            </div>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">ユーザー名</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}">
            @error('name')
                {{$message}}
            @enderror
        </div>

        <div class="mb-3">
            <label for="zipcode" class="form-label">郵便番号</label>
            <input type="text" name="zipcode" class="form-control" id="zipcode" value="{{ old('zipcode' , optional($user->address)->zipcode) }}">
            @error('zipcode')
                {{$message}}
            @enderror
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">住所</label>
            <input type="text" name="address" class="form-control" id="address" value="{{ old('address' , optional($user->address)->address) }}">
            @error('address')
                {{$message}}
            @enderror
        </div>
        <div class="mb-3">
            <label for="building" class="form-label">建物名</label>
            <input type="text" name="building" class="form-control" id="building" value="{{ old('building' , optional($user->address)->building) }}">
            @error('building')
                {{$message}}
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-danger w-100 py-2">更新する</button>
        </div>
    </form>
</div>
@endsection