@extends('layouts/contentApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-profile__container">
    <div class="profile">
        <img class="profile__image" src="{{ $isAddImage ? asset('storage/'.$profile->image) : $profile->image }}" alt="画像">
        <div>
            <p class="profile__name">{{ $profile->name }}</p>
            <div class="evaluation">
                @for ($i = 0; $i < 5; $i++)
                    <p class="star" style="color: {{ $i < $evaluation ? 'gold' : '#ccc' }};">★</p>
                    @endfor
            </div>
        </div>
    </div>
    <form action="/mypage/profile" method="get">
        <button class="profile__button">プロフィール編集</button>
    </form>
</div>

<div class="tab__container">
    <ul class="tab">
        <li><a href="#sell">出品した商品</a></li>
        <li><a href="#buy">購入した商品</a></li>
        <li>
            <a href="#transaction">
                取引中の商品
                @if (auth()->user()->unreadNotifications->count() > 0)
                <span class="tab__notification">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </a>
        </li>
    </ul>
</div>

<div class="list__container">
    {{-- 出品商品 --}}
    <div id="sell" class="list__area is-active">
        @foreach($sellProducts as $list)
        <form class="card__form" action="/item/{{ $list->id }}" method="get">
            <button class="card__item" type="submit">
                <img class="card__item-img" src="{{ asset('storage/'.$list->image) }}" alt="商品の画像">
                <div class="card__item-texts">
                    <p class="card__item-name">{{ $list->name }}</p>
                    @if ($list->buy != 0)
                    <p class="card__item-status">Sold</p>
                    @endif
                </div>
            </button>
        </form>
        @endforeach
    </div>

    {{-- 購入商品 --}}
    <div id="buy" class="list__area">
        @foreach($buyProducts as $list)
        <form class="card__form" action="/item/{{ $list->id }}" method="get">
            <button class="card__item" type="submit">
                <img class="card__item-img" src="{{ asset('storage/'.$list->image) }}" alt="商品の画像">
                <div class="card__item-texts">
                    <p class="card__item-name">{{ $list->name }}</p>
                    @if ($list->buy != 0)
                    <p class="card__item-status">Sold</p>
                    @endif
                </div>
            </button>
        </form>
        @endforeach
    </div>

    {{-- 取引中商品 --}}
    <div id="transaction" class="list__area">
        @foreach($sortedTransactionProducts as $item)
            @php
            $product = $item['product'];
            $room = $item['room'];
            $roomId = $room->id;
            $count = $unreadCounts[$roomId] ?? 0;
            @endphp

            <form class="card__form" action="/chat/{{ $room->product_id }}/{{ $room->seller }}/{{ $room->purchaser }}" method="get">
                @if ($count > 0)
                <span class="notification">{{ $count }}</span>
                @endif
                <button class="card__item" type="submit">
                    <img class="card__item-img" src="{{ asset('storage/'.$product->image) }}" alt="商品の画像">
                    <div class="card__item-texts">
                        <p class="card__item-name">{{ $product->name }}</p>
                    </div>
                </button>
            </form>
        @endforeach
    </div>
</div>

<script>
    function GethashID(hashIDName) {
        if (!hashIDName) return;

        document.querySelectorAll('.tab li').forEach(li => li.classList.remove('active'));
        document.querySelectorAll('.list__area').forEach(area => {
            area.style.opacity = 0;
            setTimeout(() => {
                area.style.display = 'none';
                area.classList.remove('is-active');
            }, 500);
        });

        document.querySelectorAll('.tab li a').forEach(link => {
            if (link.getAttribute('href') === hashIDName) {
                link.parentElement.classList.add('active');
                const targetArea = document.querySelector(hashIDName);
                if (targetArea) {
                    setTimeout(() => {
                        targetArea.classList.add('is-active');
                        targetArea.style.display = 'grid';
                    }, 500);
                    setTimeout(() => {
                        targetArea.style.opacity = 1;
                    }, 600);
                }
            }
        });
    }

    window.addEventListener('load', () => {
        document.querySelector('.tab li:first-of-type')?.classList.add('active');
        document.querySelector('.list__area:first-of-type')?.classList.add('is-active');
        GethashID(location.hash);
    });

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.tab a').forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                GethashID(link.getAttribute('href'));
            });
        });
    });
</script>
@endsection