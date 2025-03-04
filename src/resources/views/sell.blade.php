@extends('layouts.app')

@section('title')
    <title>出品画面</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
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
{{--
<h2>商品を出品する</h2>
<form action="/sell" method="post" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="">商品画像</label>
        <input type="file" id="" name="product_image_path" accept="image/*" />
    </div>
    <h3>商品の詳細</h3>
    <div>
        @foreach ($categories as $category)
        <label for="">{{$category->content}}
        </label>
        <input type="radio" name="product_category_id" id="" value="{{$category->id}}">
        @endforeach
    </div>
    <div>
        <label for="">商品の状態</label>
        <select name="condition_id" id="">
            @foreach ($conditions as $condition)
                <option value="{{$condition->id}}">{{$condition->content}}</option>
            @endforeach
        </select>
    </div>
    <h3>商品名と説明</h3>
    <div>
        <label for="">商品名</label>
        <input type="text" name="product_name" id="">
    </div>
    <div>
        <label for="">ブランド名</label>
        <input type="text" name="product_brand" id="">
    </div>
    <div>
        <label for="">商品の説明</label>
        <textarea name="product_detail" id=""></textarea>
    </div>
    <div>
        <label for="">販売価格</label>
        <input type="price" name="product_price" id="">
    </div>
    <button type="submit">出品する</button>
</form>
--}}

<div class="container py-5">
        <h2 class="text-center mb-4">商品を出品する</h2>
        <form action="/sell" method="post" enctype="multipart/form-data" class="mx-auto col-md-8">
            @csrf
            
            <!-- 商品画像 -->
            <div class="mb-3">
                <label class="form-label">商品画像</label>
                <input type="file" name="product_image_path" accept="image/*" class="form-control">
            </div>
            
            <h3 class="mt-4">商品の詳細</h3>
            
            <!-- カテゴリー -->
            <div class="mb-3">
                <label class="form-label d-block">カテゴリー</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="product_category_id" value="{{$category->id}}" id="category{{$category->id}}">
                            <label class="form-check-label badge bg-danger text-white" for="category{{$category->id}}">{{$category->content}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- 商品の状態 -->
            <div class="mb-3">
                <label class="form-label">商品の状態</label>
                <select name="condition_id" class="form-select">
                    @foreach ($conditions as $condition)
                        <option value="{{$condition->id}}">{{$condition->content}}</option>
                    @endforeach
                </select>
            </div>
            
            <h3 class="mt-4">商品名と説明</h3>
            
            <!-- 商品名 -->
            <div class="mb-3">
                <label class="form-label">商品名</label>
                <input type="text" name="product_name" class="form-control">
            </div>
            
            <!-- ブランド名 -->
            <div class="mb-3">
                <label class="form-label">ブランド名</label>
                <input type="text" name="product_brand" class="form-control">
            </div>
            
            <!-- 商品の説明 -->
            <div class="mb-3">
                <label class="form-label">商品の説明</label>
                <textarea name="product_detail" class="form-control" rows="4"></textarea>
            </div>
            
            <!-- 販売価格 -->
            <div class="mb-3">
                <label class="form-label">販売価格</label>
                <div class="input-group">
                    <span class="input-group-text">￥</span>
                    <input type="number" name="product_price" class="form-control">
                </div>
            </div>
            
            <!-- 送信ボタン -->
            <div class="text-center">
                <button type="submit" class="btn btn-danger w-100 py-2">出品する</button>
            </div>
        </form>
    </div>
@endsection
