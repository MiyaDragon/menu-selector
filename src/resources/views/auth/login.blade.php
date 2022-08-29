@extends('app')

@section('title', 'ログイン - 献立セレクター')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 mt-4 text-center fw-bolder">ログイン</h1>
    <div class="card mt-3 mx-auto">
        <div class="card-body my-3 mx-4">

            <div class="d-grid pb-3">
                <a href="{{ route('login.{provider}', ['provider' => 'google']) }}" class="btn btn-google btn-lg text-dark">
                    <i class="fab fa-google"></i>
                    <sapn>Googleでログイン</sapn>
                </a>
            </div>

            <hr>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group pt-2">
                    <label class="fw-bolder mb-1" for="email">メールアドレス</label>
                    <input type="text" class="form-control" id="email" name="email" required value="{{ old('email') }}" placeholder="mail@example.com">
                </div>

                <div class="form-group pt-4">
                    <label class="fw-bolder mb-1" for="password">パスワード</label>
                    <input type="password" class="form-control mb-1" id="password" name="password" required>
                    <a class="text-dark small" href="{{ route('password.request') }}">パスワードを忘れた方</a>
                </div>

                @if($errors->has('email'))
                <div class="text-danger">
                    {{ $errors->first('email') }}
                </div>
                @endif

                <input type="hidden" id="remember" name="remember" value="on">

                <div class="d-grid mt-4 pb-3">
                    <button type="submit" class="btn btn-success text-white btn-lg">ログイン</button>
                </div>
            </form>

            <hr>

            <div class="text-center pt-2">
                <a class="text-orange" href="{{ route('register') }}">ユーザー登録はこちら</a>
            </div>

        </div>
    </div>
</div>
@endsection
