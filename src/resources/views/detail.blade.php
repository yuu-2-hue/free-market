@extends('layouts/contentApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail__container">
    <div class="left-content__wrapper">
        <img src="{{ asset('storage/'.$product->image) }}" alt="商品の画像">
    </div>
    <div class="right-content__wrapper">
        <div class="detail__ttl">
            <p class="goods-name">{{$product->name}}</p>
            <p class="goods-brand">ブランド名</p>
            <p class="goods-price">&yen;{{ number_format($product->price) }} (税込)</p>
            <div class="goods-button">
                <form class="form" action="/item/{{$product->id}}/favorite" method="post">
                @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button name="favorite" type="submit" @class(['favorite__button--black' => !$isFavorite, 'favorite__button--orange' => $isFavorite,]) >
                        <img src="{{ asset('img/star.svg') }}" alt="">
                        <p>{{ $favoriteCount }}</p>
                    </button>
                </form>
                <a class="comment__button" href="#comment" name="comment" type="submit">
                    <img src="{{ asset('img/comment.svg') }}" alt="">
                    <p>{{ $commentCount }}</p>
                </a>
                <a href="/chat/{{$product->id}}/{{$product->sell}}/{{Auth::id()}}">取引</a>
            </div>
        </div>

        <form class="detail-form__button" action="/purchase/{{$product->id}}" method="get">
            <button type="submit">購入手続きへ</button>
        </form>

        <div class="detail__description">
            <p class="description__ttl">商品説明</p>
            <p>{{$product->detail}}</p>
        </div>

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

        <div class="detail__comment" id="comment">
            <p class="user-comment__ttl">コメント({{$commentCount}})</p>
            @foreach($comments as $comment)
                <div class="user-comment__info">
                    <img src="{{ asset('storage/'.$comment->profile->image) }}" alt="アイコン">
                    <p>{{ $comment->profile->name }}</p>
                </div>
                <p class="user-comment">{{ $comment->comment }}</p>
            @endforeach
            <p class="send-comment__ttl">商品へのコメント</p>
            <form class="send-comment__form" action="/item/{{$product->id}}/comment" method="post">
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
@endsection