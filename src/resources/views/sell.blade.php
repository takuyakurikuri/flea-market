@extends('layouts.app')

@section('title')
    <title>出品画面</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection


@section('content')

<div class="container py-5">
        <h2 class="text-center mb-4">商品を出品する</h2>
        <form action="/sell" method="post" enctype="multipart/form-data" class="mx-auto col-md-8">
            @csrf
            <div class="mb-3">
                <label class="form-label">商品画像</label>
                <input type="file" name="image_path" accept="image/*" class="form-control">
                @error('image_path')
                    {{$message}}
                @enderror
            </div>
            <h3 class="mt-4">商品の詳細</h3>
            <div class="mb-3">
                <label class="form-label d-block">カテゴリー</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="category_id[]" value="{{$category->id}}" id="category{{$category->id}}">
                            <label class="form-check-label badge bg-danger text-white" for="category{{$category->id}}">{{$category->content}}</label>
                        </div>
                    @endforeach
                    @error('category_id')
                    {{$message}}
                @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">商品の状態</label>
                <select name="condition" class="form-select">
                    <option value="">選択して下さい</option>
                    <option value="1">良好</option>
                    <option value="2">目立った傷や汚れなし</option>
                    <option value="3">やや傷や汚れあり</option>
                    <option value="4">状態が悪い</option>
                </select>
                @error('condition')
                    {{$message}}
                @enderror
            </div>
            <h3 class="mt-4">商品名と説明</h3>
            <div class="mb-3">
                <label class="form-label">商品名</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                @error('name')
                    {{$message}}
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">ブランド名</label>
                <input type="text" name="brand" class="form-control" value="{{old('brand')}}">
            </div>
            <div class="mb-3">
                <label class="form-label">商品の説明</label>
                <textarea name="detail" class="form-control" rows="4" value="{{old('detail')}}"></textarea>
                @error('detail')
                    {{$message}}
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">販売価格</label>
                <div class="input-group">
                    <span class="input-group-text">￥</span>
                    <input type="number" name="price" class="form-control" value="{{old('price')}}">
                </div>
                @error('price')
                    {{$message}}
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-danger w-100 py-2">出品する</button>
            </div>
        </form>
    </div>
@endsection
