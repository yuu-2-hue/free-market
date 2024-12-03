@extends('layouts/authApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login__container">
    <div class="login__ttl">
        <h1>ログイン</h1>
    </div>
    <form class="form" action="/login" method="post">
    @csrf
        <div class="form__item">
            <p class="item__name">メールアドレス</p>
            <input class="item__input" type="email" name="email" value="{{ old('email') }}" autocomplete="email">
            <div class="form__error">
                @error('email')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__item">
            <p class="item__name">パスワード</p>
            <input class="item__input" type="password" name="password">
            <div class="form__error">
                @error('password')
                    {{ $message }}
                @enderror
            </div>
        </div>
        <div class="button__item">
            <button class="form__button" type="submit">ログインする</button>
            <a class="form__link" href="/register">会員登録はこちら</a>
        </div>
    </form>
</div>
@endsection