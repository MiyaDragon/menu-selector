@extends('app')

@section('title', 'ログイン')

@section('content')
@include('nav')
<div class="container" style="max-width: 400px">
    <h1 class="h3 mt-4 text-center fw-bolder">ログイン</h1>
    <div class="card mt-3 mx-auto">
        <div class="card-body">

            @include('error_card_list')

            <div class="d-grid gap-2 my-4">
                <a class="btn btn-outline-dark btn-lg" href="/">
                    <i class="fab fa-google"></i>
                    <sapn>Googleでログイン</sapn>
                </a>
            </div>

            <hr>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="fw-bolder mb-2" for="email">メールアドレス</label>
                    <input type="text" class="form-control" id="email" name="email" required value="{{ old('email') }}" placeholder="mail@example.com">
                </div>

                <div class="form-group mt-4">
                    <label class="fw-bolder mb-2" for="password">パスワード</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mt-2">
                    <a class="text-dark" href="/">パスワードを忘れた方</a>
                </div>

                <input type="hidden" id="remember" name="remember" value="on">

                <div class="d-grid gap-2 my-4">
                    <button type="submit" class="btn btn-warning text-white btn-lg">ログイン</button>
                </div>
            </form>

            <hr>

            <div class="mt-2 text-center">
                <a class="text-dark" href="{{ route('register') }}">ユーザー登録はこちら</a>
            </div>

        </div>
    </div>
</div>
@endsection
