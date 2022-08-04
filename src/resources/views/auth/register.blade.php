@extends('app')

@section('title', 'ユーザー登録')

@section('content')
@include('nav')
<div class="container" style="max-width: 500px">
    <h1 class="h3 mt-4 text-center fw-bolder">献立セレクター</h1>
    <div class="card mt-3 mx-auto">
        <div class="card-body">
            <h2 class="h3 card-title my-4 text-center">新規登録</h2>
            @include('error_card_list')
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">ユーザーネーム（登録後に変更可能）</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}" placeholder="例：太郎（50文字以内）">
                </div>

                <div class="form-group mt-2">
                    <label for="email">メールアドレス</label>
                    <input type="text" class="form-control" id="email" name="email" required value="{{ old('email') }}" placeholder="例：example@example.com">
                </div>

                <div class="form-group mt-2">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="例：8文字以上の半角英数">
                </div>

                <div class="form-group mt-2">
                    <label for="password_confirmation">パスワード（確認）</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="d-grid gap-2 my-4">
                    <button type="submit" class="btn btn-warning text-white btn-lg">登録する</button>
                </div>
            </form>
            <hr>
            <div class="d-grid gap-2 my-4">
                <a class="btn btn-danger text-white btn-lg" href="/">
                    <i class="fab fa-google"></i>
                    <sapn>Googleで登録</sapn>
                </a>
            </div>
            <hr>
            <div class="d-grid gap-2 my-4">
                <p class="text-center mb-0">アカウントをお持ちの方</p>
                <a class="btn btn-outline-warning btn-lg" href="{{ route('login') }}">ログイン</a>
            </div>
        </div>
    </div>
</div>
@endsection
