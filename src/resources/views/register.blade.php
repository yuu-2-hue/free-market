@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__container">
    <div class="register__ttl">
        <h1>会員登録</h1>
    </div>
    <form class="form" action="">
        <div class="form__unit">
            <div class="form__item">
                <p class="item__name">ユーザー名</p>
                <input class="item__input" type="text" name="name">
            </div>
            <div class="form__item">
                <p class="item__name">メールアドレス</p>
                <input class="item__input" type="email" name="email">
            </div>
            <div class="form__item">
                <p class="item__name">パスワード</p>
                <input class="item__input" type="password" name="password">
            </div>
            <div class="form__item">
                <p class="item__name">確認用パスワード</p>
                <input class="item__input" type="password" name="password_confirmation">
            </div>
        </div>
        <div class="button__unit">
            <button class="form__button" type="submit">登録する</button>
            <a class="form__link" href="">ログインはこちら</a>
        </div>
    </form>
</div>
@endsection