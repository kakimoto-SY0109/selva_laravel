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

@if (session('success'))
    <div class="flash-message" id="flash-message">
        {{ session('success') }}
    </div>
@endif
</div>
@endsection
<style>
.flash-message {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    max-width: 800px;
    background-color: #888;
    color: #fff;
    padding: 16px 28px;
    border-radius: 8px;
    font-size: 16px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    z-index: 9999;
    opacity: 1;
    transition: opacity 0.5s ease-in-out;
    cursor: pointer;
}
</style>
@section('scripts')
<script>
    function hideFlash() {
        const flash = document.getElementById('flash-message');
        if (flash) {
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
        }
    }

    setTimeout(hideFlash, 10000);

    // クリックでも消える
    document.addEventListener('DOMContentLoaded', function () {
        const flash = document.getElementById('flash-message');
        if (flash) {
            flash.addEventListener('click', hideFlash);
        }
    });
</script>

@endsection