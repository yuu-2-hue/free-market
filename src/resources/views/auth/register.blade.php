@extends('layouts/authApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="register__container">
    <div class="register__ttl">
        <h1>会員登録</h1>
    </div>
    <form class="form" action="/register" method="post">
    @csrf
        <div class="form__item">
            <p class="item__name">ユーザー名</p>
            <input class="item__input" type="text" name="name" value="{{ old('name') }}" autocomplete="name">
            <div class="form__error">
                @error('name') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__item">
            <p class="item__name">メールアドレス</p>
            <input class="item__input" type="email" name="email" value="{{ old('email') }}" autocomplete="email">
            <div class="form__error">
                @error('email') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__item">
            <p class="item__name">パスワード</p>
            <input class="item__input" type="password" name="password">
            <div class="form__error">
                @error('password') {{ $message }} @enderror
            </div>
        </div>
        <div class="form__item">
            <p class="item__name">確認用パスワード</p>
            <input class="item__input" type="password" name="password_confirmation">
            <div class="form__error">
                @error('password_confirmation') {{ $message }} @enderror
            </div>
        </div>
        <div class="button__item">
            <button class="form__button" type="submit">登録する</button>
            <a class="form__link" href="/login">ログインはこちら</a>
        </div>
    </form>
</div>
@endsection