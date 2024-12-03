@extends('layouts.contentApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile__container">
    <div class="profile__ttl">
        <p>プロフィール設定</p>
    </div>
    <form class="form" action="/mypage/profile" method="post" enctype="multipart/form-data">
    @csrf
        <div class="form__item">
            <div class="profile__image">
                @if($isAddProfile)
                <img src="{{ asset('storage/'.$profile->image) }}" alt="ユーザー画像">
                @else
                <img src="{{ asset('img/kkrn_icon_user_14.png') }}" alt="ユーザー画像">
                @endif
                <input type="file" name="image">
            </div>
            <div class="form__error">
                @error('image') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__item">
            <p class="item__name">ユーザー名</p>
            @if($isAddProfile)
            <input class="item__input" type="text" name="name" value="{{ old('name', $profile->name) }}" autocomplete="name">
            @else
            <input class="item__input" type="text" name="name" value="{{ old('name', $userName) }}" autocomplete="name">
            @endif
        </div>
        <div class="form__item">
            <p class="item__name">郵便番号</p>
            @if($isAddProfile)
            <input class="item__input" type="text" name="post_code" value="{{ old('post_code', $profile->post_code) }}" autocomplete="post_code">
            @else
            <input class="item__input" type="text" name="post_code" value="{{ old('post_code') }}" autocomplete="post_code">
            @endif
        </div>
        <div class="form__item">
            <p class="item__name">住所</p>
            @if($isAddProfile)
            <input class="item__input" type="text" name="address" value="{{ old('address', $profile->address) }}" autocomplete="address">
            @else
            <input class="item__input" type="text" name="address" value="{{ old('address') }}" autocomplete="address">
            @endif
        </div>
        <div class="form__item">
            <p class="item__name">建物名</p>
            @if($isAddProfile)
            <input class="item__input" type="text" name="building" value="{{ old('building', $profile->building) }}" autocomplete="building">
            @else
            <input class="item__input" type="text" name="building" value="{{ old('building') }}" autocomplete="building">
            @endif
        </div>
        <button class="form__button" type="submit">更新する</button>
    </form>
</div>
@endsection