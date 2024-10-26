<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreeMarket</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>
<body>
    <header class="header__container">
        <div class="header__inner">
            <a class="header__logo" href="">
                <img src="{{ asset('img/logo.svg') }}" alt="logo画像">
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>