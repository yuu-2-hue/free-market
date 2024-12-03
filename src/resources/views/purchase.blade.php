@extends('layouts/contentApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase__container">
    <form class="form" action="/purchase/{{$product->id}}/checkout" method="post">
        @csrf
        <div class="left__wrapper">
            <div class="top__item">
                <div class="top-item__image">
                    <img src="{{ asset('storage/'.$product->image) }}" alt="商品画像">
                </div>
                <div class="top-item__info">
                    <p class="info__name">{{ $product->name }}</p>
                    <p class="info__price">&yen;{{ number_format($product->price) }}</p>
                </div>
            </div>
            <div class="center__item">
                <p class="center-item__name">支払い方法</p>
                <select class="center-item__select" id="payment" name="payment" onchange="myfunc()">
                    <option value="" hidden>選択してください</option>
                    @foreach($payments as $payment)
                    <option value="{{$payment->id}}">{{ $payment->payment }}</option>
                    @endforeach
                </select>
                <div class="form__error">
                    @error('payment') {{ $message }} @enderror
                </div>
            </div>
            <div class="under__item">
                <div class="under-item__ttl">
                    <p class="under-item__name">配送先</p>
                    <a class="under-item__button" href="/purchase/address/{{$product->id}}">変更する</a>
                </div>
                <div class="under-item__shipping-address">
                    <input class="under-item__post-code" name="post_code" value="{{ $profile->post_code }}" readonly>
                    <div class="form__error">
                        @error('post_code') {{ $message }} @enderror
                    </div>
                    <input class="under-item__address" name="address" value="{{ $profile->address }}" readonly>
                    <div class="form__error">
                        @error('address') {{ $message }} @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="right__wrapper">
            <table class="right-item__table">
                <tr>
                    <td>商品代金</td>
                    <td>&yen;{{ number_format($product->price) }}</td>
                </tr>
                <tr>
                    <td>支払い方法</td>
                    <td id = "selected-text">選択してください</td>
                </tr>
            </table>
            <button onClick="location.href='/purchase/{{$product->id}}/checkout'" class="right-item__button">購入する</button>
        </div>
    </form>
</div>

<script>
    function myfunc() {

        var value = document.getElementById("payment").value;
        var target = document.getElementById("selected-text");

        var text = '';
        if(value == 1){
            text = 'コンビニ払い';
        }
        else if(value == 2){
            text = 'カード払い';
        }
        target.innerHTML = text;
    }
</script>
@endsection