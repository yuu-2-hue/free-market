@extends('layouts/contentApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-profile__container">
    <div class="profile">
        @if($isAddImage)
        <img class="profile__image" src="{{ asset('storage/'.$profile->image) }}" alt="画像">
        @else
        <img class="profile__image" src="{{ $profile->image }}" alt="画像">
        @endif
        <p class="profile__name">{{$profile->name}}</p>
    </div>
    <form action="/mypage/profile" method="get">
        <button class="profile__button" name="">プロフィール編集</button>
    </form>
</div>
<div class="mypage-tab__container">
    <div class="mypage-tab__item">
        <form class="form" action="/mypage" method="get">
            <button name="tab" value="sell" @class(['item__tab--red' => $tab=="sell", 'item__tab--black' => $tab=="buy",])>出品した商品<button>
            <button name="tab" value="buy" @class(['item__tab--red' => $tab=="buy", 'item__tab--black' => $tab=="sell",])>購入した商品<button>
        </form>
    </div>
</div>
<div class="mypage__container">
    @if(Auth::check())
        @foreach($lists as $list)
            <form class="card__form" action="/item/{{$list->id}}" method="get">
                <button class="card__item" type="submit">
                    <img class="card__item-img" src="{{ asset('storage/'.$list->image) }}" alt="商品の画像">
                    <div class="card__item-texts">
                        <p class="card__item-name">{{$list->name}}</p>
                        @if($list->buy != 0)
                            <p class="card__item-status">Sold</p>
                        @endif
                    </div>
                </button>
            </form>
        @endforeach
    @endif
</div>
@endsection