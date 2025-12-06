@extends('admin.layout')
@section('title', '管理画面トップ')
@section('content')
<div class="container">
    <h1>管理画面トップ</h1>
    @auth('admin')
        <p style="text-align: center; margin-top: 20px;">管理画面にログイン中です</p>
    @else
        <p style="text-align: center; margin-top: 20px;">管理画面へようこそ</p>
    @endauth
</div>
@endsection