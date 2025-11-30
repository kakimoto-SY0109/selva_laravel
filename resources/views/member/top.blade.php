@extends('member.layout')
@section('title', 'トップページ')
@section('content')
<div class="container">
    <h1>トップページ</h1>
    @auth('member')
        <p style="text-align: center; margin-top: 20px;">ログイン中です</p>
        
    @else
        <p style="text-align: center; margin-top: 20px;">⚪︎⚪︎サイトへようこそ</p>
    @endauth
</div>
@endsection