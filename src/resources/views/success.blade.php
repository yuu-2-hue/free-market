@extends('layouts/authApp')

@section('css')
<link rel="stylesheet" href="{{ asset('css/success.css') }}">
@endsection

@section('content')
<div class="success__container">
    <h2>ご購入ありがとうございます</h2>
    <a href="/mypage">マイページへ</a>
</div>
@endsection