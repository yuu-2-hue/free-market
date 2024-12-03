@extends('layouts/contentApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="list-tab__container">
    <div class="list-tab__wrapper">
        <div class="list-tab__item">
            <a href="/" name="tab" value="list" @class(['item__tab--red' => $tab=="list", 'item__tab--black' => $tab=="mylist",])>おすすめ</a>
        </div>
        <div class="list-tab__item">
            <form class="form" action="/" method="get">
                <button name="tab" value="mylist" @class(['item__tab--red' => $tab=="mylist", 'item__tab--black' => $tab=="list",])>マイリスト</button>
            </form>
        </div>
    </div>
</div>
<div class="list__container">
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
</div>
@endsection