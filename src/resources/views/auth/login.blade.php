@extends('app')

@section('title', 'ログイン')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 my-4 text-center fw-bolder">ログイン</h1>
    <div class="card mx-auto">
        <div class="card-body mx-4 my-3">

            <div class="d-grid gap-2">
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

                <div class="my-2">
                    <a class="text-dark" href="{{ route('password.request') }}">パスワードを忘れた方</a>
                </div>

                @if($errors->has('email'))
                <div class="text-danger">
                    {{ $errors->first('email') }}
                </div>
                @endif

                <input type="hidden" id="remember" name="remember" value="on">

                <div class="d-grid gap-2 my-3">
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
