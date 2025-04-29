@extends('layouts/authApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('content')
<div class="chat__container">
    <div class="side__container">
        <p>その他のお取引</p>
        <a href="">aaa</a>
    </div>
    <div class="main__container">
        <div class="chat-partner__wrapper">
            <div class="info">
                <img src="{{ asset('storage/'.$receiver->profile->image) }}" alt="ユーザー画像">
                <p>「{{$receiver->name}}」さんとの取引画面</p>
            </div>
            <div class="button">
                <a href="#modal">取引完了</a>
            </div>
        </div>
        <div class="product__wrapper">
            <img src="{{ asset('storage/'.$product->image) }}" alt="商品画像">
            <div class="info">
                <p class="name">{{$product->name}}</p>
                <p class="price">{{$product->price}}</p>
            </div>
        </div>
        <div class="message-list__wrapper">
            @foreach($chats as $chat)
            @if($chat->sender != Auth::id())
            <div class="receiver__wrapper">
                <div class="user-info">
                    <img src="{{ asset('storage/'.$user->profile->image) }}" alt="ユーザー画像">
                    <p>{{$user->name}}</p>
                </div>
                <input class="message" type="text" value="{{$chat->message}}">
            </div>
            @else
            <div class="sender__wrapper">
                <div class="user-info">
                    <p>{{$receiver->name}}</p>
                    <img src="{{ asset('storage/'.$receiver->profile->image) }}" alt="ユーザー画像">
                </div>
                <form class="message__form" action="/chat/{{$product->id}}/{{$product->sell}}/{{Auth::id()}}/message" method="post">
                    @csrf
                    <input type="hidden" value="{{$chat->id}}" name="id">
                    <input class="message" type="text" value="{{$chat->message}}" name="message">
                    <button type="submit" name="edit">編集</button>
                    <button type="submit" name="delete">削除</button>
                </form>
            </div>
            @endif
            @endforeach
        </div>
        <div class="message-send__wrapper">
            <div class="form__error">
                @error('message') {{ $message }} @enderror
            </div>
            <div class="form__error">
                @error('image') {{ $message }} @enderror
            </div>
            <form action="/chat/{{$product->id}}/{{$product->sell}}/{{Auth::id()}}" method="post">
                @csrf
                <input class="message" type="text" name="message" value="{{session('chat_message')}}" placeholder="取引メッセージを記入してください">
                <div class="file__wrapper">
                    <span id="file__name" style="display: block;"></span>
                    <label for="file" class="file__label">画像を追加</label>
                    <input id="file" class="file" type="file" name="image" onchange="updateLabel(this)">
                </div>
                <button type="submit"><img src="{{ asset('img/input-button.jpg') }}" alt="送信"></button>
            </form>
        </div>
    </div>
</div>
<div id="modal" class="modal__container">
    <form action="/chat/{{$product->id}}/{{$product->sell}}/{{Auth::id()}}/rating" method="post">
        @csrf
        <h2>取引が完了しました。</h2>
        <div class="evaluation">
            <p>今回の取引相手はどうでしたか？</p>
            <div class="star-rating">
                @for ($i = 5; $i >= 1; $i--)
                <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}">
                <label for="star{{$i}}">★</label>
                @endfor
            </div>
        </div>
        <div class="button">
            <button type="submit">送信する</button>
        </div>
    </form>
</div>
<script>
    // 画面縦サイズ取得
    window.addEventListener('resize', () => {
        let vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    });

    // 画像名を表示
    function updateLabel(input) {
        const fileNameElement = document.getElementById("file__name");
        if (input.files.length > 0) {
            fileNameElement.textContent = input.files[0].name;
        } else {
            fileNameElement.textContent = "選択されていません";
        }
    }

    // 入力されたらサーバーにメッセージを送信
    document.querySelector('.message').addEventListener('input', function() {
        const formData = {
            _token: document.querySelector('input[name="_token"]').value,
            message: document.querySelector('.message').value,
        };

        fetch('/chat/{{$product->id}}/{{$product->sell}}/{{Auth::id()}}/save-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': formData._token
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (response.ok) {
                    console.log('メッセージが保存されました');
                } else {
                    alert('保存に失敗しました');
                }
            });
    });
</script>
@endsection