@extends('layouts/contentApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell__container">
    <h3 class="sell__ttl">商品の出品</h3>
    <form class="form" action="/sell" method="post" enctype="multipart/form-data">
    @csrf
        <div class="sell__item-image">
            <p class="item-image__name">商品画像</p>
            <input class="item-image__file" type="file" name="image">
            <div class="form__error">
                @error('image') {{ $message }} @enderror
            </div>
        </div>

        <div class="sell__item-detail">
            <h4 class="item-detail__ttl">商品の詳細</h4>
            <div class="item-detail__category">
                <p class="item-detail__name">カテゴリー</p>
                <div class="item-detail__checkbox">
                    @foreach($categories as $category)
                    <label class="checkbox__label">
                        <input class="checkbox__input" type="checkbox" name="category[]" value="{{$category->id}}"
                        {{ is_array(old('category')) && in_array($category->id, old('category')) ? 'checked=checked' : '' }} />
                        <span>{{$category->category}}</span>
                    </label>
                    @endforeach
                </div>

                <div class="form__error">
                    @error('category') {{ $message }} @enderror
                </div>
            </div>
            <div class="item-detail__condition">
                <p class="item-detail__name">商品の状態</p>
                <select class="item-detail__select" name="condition" id="">
                    <option value="" hidden>選択してください</option>
                    @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition')==$condition->id ? 'selected' : '' }}>{{$condition->condition}}
                    </option>
                    @endforeach
                </select>
                <div class="form__error">
                    @error('condition') {{ $message }} @enderror
                </div>
            </div>
        </div>

        <div class="sell__item-explanation">
            <h4 class="item-detail__ttl">商品の名前と説明</h4>
            <div class="item-explanation">
                <p class="item-explanation__name">商品名</p>
                <input class="name__input" type="text" name="name" value="{{old('name')}}">
                <div class="form__error">
                    @error('name') {{ $message }} @enderror
                </div>
            </div>
            <div class="item-explanation">
                <p class="item-explanation__name">商品の説明</p>
                <textarea class="text__input" name="explanation" id="">{{old('explanation')}}</textarea>
                <div class="form__error">
                    @error('explanation') {{ $message }} @enderror
                </div>
            </div>
            <div class="item-explanation">
                <p class="item-explanation__name">販売価格</p>
                <input class="price__input" type="text" name="price" value="{{old('price')}}">
                <div class="form__error">
                    @error('price') {{ $message }} @enderror
                </div>
            </div>
        </div>

        <button class="button" type="submit">出品する</button>
    </form>
</div>
@endsection