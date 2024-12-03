<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreeMarket</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layouts/contentCommon.css') }}" />
    @yield('css')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="header__container">
        <div class="header__inner">
            <div class="header__item">
                <a class="header__logo" href="/">
                    <img src="{{ asset('img/logo.svg') }}" alt="logo画像">
                </a>
                <div class="header-search__item">
                    <form action="/" method="post">
                    @csrf
                        <input class="header-search__input" name="keyword" type="search" value="{{ old('keyword', $keyword) }}" placeholder="なにをお探しですか？" autocomplete="keyword">
                    </form>
                </div>
                <ul class="header-nav">
                    <li class="header-nav__item">
                        @if (Auth::check())
                            <form action="/logout" method="post">
                            @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        @elseif(!Auth::check())
                            <a class="header-nav__link" href="/login">ログイン</a>
                        @endif
                    </li>
                    <li class="header-nav__item">
                        <a class="header-nav__link" href="/mypage">マイページ</a>
                    </li>
                    <li class="header-nav__item">
                        <a class="header-nav__link--button" href="/sell">出品</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>