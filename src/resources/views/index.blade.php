@extends('layouts/contentApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="tab__container">
    <ul class="tab">
        <li><a href="#recommendation">おすすめ</a></li>
        <li><a href="#mylist">マイリスト</a></li>
    </ul>
</div>
<div class="list__container">
    <div id="recommendation" class="list__area is-active">
        @foreach($products as $list)
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
    <div id="mylist" class="list__area">
        @foreach($mylists as $list)
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
</div>

<script>
    // ハッシュIDからタブをアクティブにする関数
    function GethashID(hashIDName) {
        if (hashIDName) {
            var tabLinks = document.querySelectorAll('.tab li a');

            tabLinks.forEach(function(link) {
                var idName = link.getAttribute('href');
                if (idName === hashIDName) {
                    var parentElm = link.parentElement;
                    // すべてのタブからactiveクラスを外す
                    document.querySelectorAll('.tab li').forEach(function(li) {
                        li.classList.remove('active');
                    });
                    // クリックしたタブにactiveクラスを付与
                    parentElm.classList.add('active');

                    // すべてのエリアを非表示にする
                    document.querySelectorAll('.list__area').forEach(function(area) {
                        area.style.opacity = 0;
                        setTimeout(() => {
                            area.style.display = 'none';
                            area.classList.remove('is-active');
                        }, 500);
                    });

                    // 対象エリアをフェードイン表示
                    var targetArea = document.querySelector(hashIDName);
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
    }

    // ページの読み込み完了時
    window.addEventListener('load', function() {
        // 最初のタブをアクティブにする
        var firstTab = document.querySelector('.tab li:first-of-type');
        var tabArea = document.querySelector('.area:first-of-type');
        if (firstTab) {
            firstTab.classList.add('active');
        }
        if (tabArea) {
            tabArea.classList.add('is-active');
        }

        // URLのハッシュがあれば、それを使ってタブをアクティブにする
        var hashName = location.hash;
        GethashID(hashName);
    });

    // タブリンククリック時
    document.addEventListener('DOMContentLoaded', function() {
        var tabLinks = document.querySelectorAll('.tab a');

        tabLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // デフォルトリンク動作キャンセル
                var idName = this.getAttribute('href');
                GethashID(idName);
            });
        });
    });
</script>
@endsection