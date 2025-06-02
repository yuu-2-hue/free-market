@extends('layouts/authApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('content')
<div class="chat__container">
    {{-- サイドバー（他の取引） --}}
    <div class="side__container">
        <p>その他のお取引</p>
        @if(Auth::id() == $product->sell)
        @foreach($transactions as $transaction)
        <a href="/chat/{{ $transaction->product_id }}/{{ $transaction->seller }}/{{ $transaction->purchaser }}">
            {{ $transaction->product->name }}
        </a>
        @endforeach
        @endif
    </div>

    {{-- メインチャットエリア --}}
    <div class="main__container">

        {{-- チャット相手情報 --}}
        <div class="chat-partner__wrapper">
            <div class="info">
                <img src="{{ asset('storage/'.$receiver->profile->image) }}" alt="ユーザー画像">
                <p>「{{ $receiver->name }}」さんとの取引画面</p>
            </div>
            @if(Auth::id() != $product->sell)
            <div class="button">
                <a href="#modal">取引完了</a>
            </div>
            @endif
        </div>

        {{-- 商品情報 --}}
        <div class="product__wrapper">
            <img src="{{ asset('storage/'.$product->image) }}" alt="商品画像">
            <div class="info">
                <p class="name">{{ $product->name }}</p>
                <p class="price">{{ $product->price }}</p>
            </div>
        </div>

        {{-- メッセージ一覧 --}}
        <div class="message-list__wrapper">
            @foreach($chats as $chat)
            @if($chat->sender != Auth::id())
            {{-- 受信メッセージ --}}
            <div class="receiver__wrapper">
                <div class="user-info">
                    <img src="{{ asset('storage/'.$user->profile->image) }}" alt="ユーザー画像">
                    <p>{{ $receiver->name }}</p>
                </div>
                @if ($chat->image)
                <div class="chat__image">
                    <img src="{{ asset('storage/' . $chat->image) }}" alt="画像メッセージ">
                </div>
                @endif
                @if ($chat->message)
                <input class="message" type="text" name="receiver-message" value="{{ $chat->message }}" readonly>
                @endif
            </div>
            @else
            {{-- 送信メッセージ --}}
            <div class="sender__wrapper">
                <div class="user-info">
                    <p>{{ $user->name }}</p>
                    <img src="{{ asset('storage/'.$receiver->profile->image) }}" alt="ユーザー画像">
                </div>
                @if ($chat->image)
                <div class="chat__image">
                    <img src="{{ asset('storage/' . $chat->image) }}" alt="画像メッセージ">
                </div>
                @endif
                @if ($chat->message)
                <input id="edit-message{{$chat->id}}" class="message" type="text" name="message" value="{{ $chat->message }}" readonly>
                @endif
                <div class="message-button">
                    <button class="edit-button" type="submit" name="edit" data-id="{{ $chat->id }}">編集</button>
                    <button class="delete-button" type="submit" name="delete" data-id="{{ $chat->id }}">削除</button>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        {{-- メッセージ送信フォーム --}}
        <div class="message-send__wrapper">
            <div class="form__error">
                @error('message') {{ $message }} @enderror
            </div>
            <div class="form__error">
                @error('image') {{ $message }} @enderror
            </div>
            <form class="message__form" @if($room==null) action="/chat/{{ $product->id }}/{{ $product->sell }}/{{ Auth::id() }}" @else action="/chat/{{ $room->product_id }}/{{ $room->seller }}/{{ $room->purchaser }}" @endif method="post" enctype="multipart/form-data">
                @csrf
                <input id="message" class="message" type="text" name="message" value="{{ session('chat_message') }}" placeholder="取引メッセージを記入してください">

                <div class="file__wrapper">
                    <span id="file__name" style="display: block;"></span>
                    <label for="file" class="file__label">画像を追加</label>
                    <input id="file" class="file" type="file" name="image" onchange="updateLabel(this)">
                </div>

                <button type="submit">
                    <img src="{{ asset('img/input-button.jpg') }}" alt="送信">
                </button>
            </form>
        </div>
    </div>
</div>

{{-- モーダル：取引完了 --}}
<div id="modal" class="modal__container">
    <form class="message__form" @if($room==null) action="/chat/{{ $product->id }}/{{ $product->sell }}/{{ Auth::id() }}/rating" @else action="/chat/{{ $room->product_id }}/{{ $room->seller }}/{{ $room->purchaser }}/rating" @endif method="post">
        @csrf
        <h2>取引が完了しました。</h2>
        <div class="evaluation">
            <p>今回の取引相手はどうでしたか？</p>
            <div class="star-rating">
                @for ($i = 5; $i >= 1; $i--)
                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                <label for="star{{ $i }}">★</label>
                @endfor
            </div>
        </div>
        <div class="button">
            <button type="submit">送信する</button>
        </div>
    </form>
</div>

{{-- JavaScript --}}
<script>
    // 画面の高さをCSS変数に設定
    window.addEventListener('resize', () => {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    });

    ["DOMContentLoaded", "resize"].forEach((eventType) => {
        window.addEventListener(eventType, () => {
            const headerHeight = document.querySelector('.header__inner').offsetHeight;
            const containerHeight = document.querySelector('.chat__container').offsetHeight;
            const partnerHeight = document.querySelector('.chat-partner__wrapper').offsetHeight;
            const productHeight = document.querySelector('.product__wrapper').offsetHeight;
            const messageHeight = document.querySelector('.message-send__wrapper').offsetHeight;

            let messageList = document.querySelector('.message-list__wrapper');
            const resultHeight = containerHeight - (headerHeight + partnerHeight + productHeight + messageHeight);
            messageList.style.height = resultHeight + 'px';
        });
    });

    // ファイル選択時にファイル名表示
    function updateLabel(input) {
        const fileNameElement = document.getElementById("file__name");
        fileNameElement.textContent = input.files.length > 0 ?
            input.files[0].name :
            "選択されていません";
    }

    // 自動保存処理（入力中にメッセージ保存）
    document.querySelector('#message').addEventListener('input', function() {
        const formData = {
            _token: document.querySelector('input[name="_token"]').value,
            message: this.value
        };

        fetch('/chat/{{ $product->id }}/{{ $product->sell }}/{{ Auth::id() }}/save-message', {
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

    // 送信済みメッセージの編集
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function() {
            let id = this.dataset.id;
            let input = document.querySelector('#edit-message' + id);

            input.readOnly = false;
            input.focus();

            input.addEventListener('blur', async function() {
                input.readOnly = true;
                let newMessage = input.value;

                try {
                    const response = await fetch('/chat/message/edit/' + id, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            message: newMessage
                        })
                    });

                    const result = await response.json();
                    if (response.ok) {
                        console.log('更新成功:', result.message);
                    } else {
                        console.error('更新失敗:', result.message || result);
                    }
                } catch (error) {
                    console.error('通信エラー:', error);
                }
            }, {
                once: true
            });
        });
    });

    // 削除
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', async function() {
            const id = this.dataset.id;

            if (!confirm('このメッセージを削除しますか？')) {
                return;
            }

            try {
                const response = await fetch('/chat/message/delete/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    console.log('削除成功:', result);
                    const wrapper = this.closest('.sender__wrapper');
                    if (wrapper) wrapper.remove();
                } else {
                    console.error('削除失敗:', result.message || result);
                }
            } catch (error) {
                console.error('通信エラー:', error);
            }
        });
    });
</script>
@endsection