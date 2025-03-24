@extends('layouts.app')

@section('title')
    <title>商品購入画面</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <div class="container main-content">
        <div class="row">
            <div class="col-md-8">
                <div class="d-flex">
                    <img class="product-image" src="{{ asset('storage/' . $item->item_image_path) }}" alt="{{$item->item_name}}">
                    <div class="ms-4">
                        <h2>{{$item->item_name}}</h2>
                        <h3 class="text-danger">¥{{number_format($item->item_price)}}</h3>
                    </div>
                </div>

                <hr>

                <h4>支払い方法</h4>
                <select name="payment-method" id="payment-method" class="form-select w-50" value="{{old('payment-method')}}">
                    <option value="">選択してください</option>
                    <option name="payment_method" value="1">カード支払い</option>
                    <option name="payment_method" value="2">コンビニ払い</option>
                </select>

                <hr>

                <h4>配送先</h4>
                
                    @if (session('changeAddress'))
                        <p>〒{{session('changeAddress.zipcode')}}<br>
                        {{session('changeAddress.address')}} {{session('changeAddress.building')}}
                        </p>
                    @else
                        <p>〒{{$zipcode}}<br>
                            {{$user->profile->address->address}} {{$user->profile->address->building}}
                        </p>
                    @endif
                <a href="/purchase/address/{{$item->id}}" class="text-primary">変更する</a>
            </div>
            <div class="col-md-4">
                <div class="purchase-box">
                    <p><strong>商品代金</strong> ¥{{number_format($item->item_price)}}</p>
                    <div class="d-flex">
                        <p class=" me-2"><strong>支払い方法</strong></p>
                        <p id="selected-payment">支払い方法を選択して下さい</p>
                    </div>
                </div>
                <form action="/item/{{$item->id}}/purchase" method="post">
                    @csrf
                    <input type="hidden" name="purchase_item_id" value="{{$item->id}}">
                    @if (session('changeAddress'))
                        <input type="hidden" name="zipcode" value="{{session('changeAddress.zipcode')}}">
                        <input type="hidden" name="address" value="{{session('changeAddress.address')}}">
                        <input type="hidden" name="building" value="{{session('changeAddress.building')}}">
                    @else
                        <input type="hidden" name="zipcode" value="{{$zipcode}}">
                        <input type="hidden" name="address" value="{{$user->profile->address->address}}">
                        <input type="hidden" name="building" value="{{$user->profile->address->building}}">
                    @endif
                    <input name="payment_method" type="hidden" id="hidden-payment-method" value="">
                    <button type="submit" class="btn btn-purchase mt-3">購入する</button>
                </form>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('payment-method').addEventListener('change', function() {
        const selectedText = this.options[this.selectedIndex].text;
        document.getElementById('selected-payment').textContent = this.value ? selectedText : '支払い方法を選択して下さい';
        document.getElementById('hidden-payment-method').value = this.value;
    });

    </script>
@endsection
