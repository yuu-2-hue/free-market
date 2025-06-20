@extends('layouts/contentApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail__container">
    {{-- 商品画像 --}}
    <div class="left-content__wrapper">
        <img src="{{ asset('storage/'.$product->image) }}" alt="商品の画像">
    </div>

    {{-- 商品情報 --}}
    <div class="right-content__wrapper">
        <div class="detail__ttl">
            <p class="goods-name">{{$product->name}}</p>
            <p class="goods-brand">ブランド名</p>
            <p class="goods-price">&yen;{{ number_format($product->price) }} (税込)</p>

            {{-- お気に入りボタン、コメント遷移ボタン、取引ボタン --}}
            <div class="goods-button">
                <div class="favorite">
                    <a id="favorite-button" class="favorite" name="favorite" type="submit" data-url="{{ route('item.favorite', ['item_id' => $product->id]) }}">
                        <img id="favorite-img" src="{{ asset('img/star.svg') }}" class="favorite-img {{ $isFavorited ? 'is-active' : '' }}">
                    </a>
                    <span id="favorite-count">{{ $favoriteCount }}</span>
                </div>
                <div class="comment">
                    <a class="comment__button" href="#comment" name="comment" type="submit">
                        <img src="{{ asset('img/comment.svg') }}" alt="">
                    </a>
                    <span>{{ $commentCount }}</span>
                </div>
                <div class="transaction">
                    <a href="/chat/{{$product->id}}/{{$product->sell}}/{{Auth::id()}}">取引</a>
                </div>
            </div>
        </div>

        {{-- 購入手続きへ遷移 --}}
        <form class="detail-form__button" action="/purchase/{{$product->id}}" method="get">
            <button type="submit">購入手続きへ</button>
        </form>

        {{-- 商品説明 --}}
        <div class="detail__description">
            <p class="description__ttl">商品説明</p>
            <p>{{$product->detail}}</p>
        </div>

        {{-- 商品のカテゴリー・状態 --}}
        <div class="detail__info">
            <p class="info__ttl">商品の情報</p>
            <div class="info__category">
                <p class="category__ttl">カテゴリー</p>
                <div class="category__tag">
                    @foreach($product->categories as $category)
                    <p class="category__name">{{$category->category}}</p>
                    @endforeach
                </div>
            </div>
            <div class="info__condition">
                <p class="condition__ttl">商品の状態</p>
                <p class="condition__name">{{ $condition->condition }}</p>
            </div>
        </div>

        {{-- コメント送信 --}}
        <div class="detail__comment" id="comment">
            <div class="comment__ttl">
                <span class="user-comment__ttl">コメント({{$commentCount}})</span>
            </div>
            <div id="comment-list" class="comment__list">
                @foreach($comments as $comment)
                <div class="user-comment__info">
                    <img src="{{ asset('storage/'.$comment->profile->image) }}" alt="アイコン">
                    <p>{{ $comment->profile->name }}</p>
                </div>
                <p class="user-comment">{{ $comment->comment }}</p>
                @endforeach
            </div>
            <div class="comment__form">
                <p class="send-comment__ttl">商品へのコメント</p>
                <form id="comment-form" data-url="{{ route('item.comment', ['item_id' => $product->id]) }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <textarea class="send-comment__textarea" name="comment"></textarea>
                    <div class="form__error">
                        @error('comment') {{ $message }} @enderror
                    </div>
                    <button class="send-comment__button" type="submit">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/favorite.js') }}"></script>
<script src="{{ asset('js/comment.js') }}"></script>
@endsection