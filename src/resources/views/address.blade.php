@extends('layouts/contentApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address__container">
    <h1 class="address__ttl">住所の変更</h1>
    <form class="form" action="/purchase/address/{{$product_id}}" method="post">
    @csrf
        <div class="address__wrapper">
            <div class="address__item">
                <p class="item__name">郵便番号</p>
                <input class="item__input" type="text" name="post_code" value="{{ old('post_code', $profile->post_code) }}" autocomplete="post_code">
                <div class="form__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="address__item">
                <p class="item__name">住所</p>
                <input class="item__input" type="text" name="address" value="{{ old('address', $profile->address) }}" autocomplete="address">
                <div class="form__error">
                    @error('post_code')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="address__item">
                <p class="item__name">建物名</p>
                <input class="item__input" type="text" name="building" value="{{ old('building', $profile->building) }}" autocomplete="building">
                <div class="form__error">
                    @error('address')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <button class="button" type="submit">更新する</button>
    </form>
</div>
@endsection