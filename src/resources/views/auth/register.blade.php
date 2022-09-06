@extends('app')

@section('title', 'ユーザー登録 - 献立セレクター')

@section('content')
@include('nav')
<div class="container" style="max-width: 480px">
    <h1 class="h3 mt-4 text-center fw-bolder">ユーザー登録</h1>
    <div class="card mt-3 mb-5 mx-auto">
        <div class="card-body my-3 mx-4">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">ユーザーネーム</label>
                    <sapn class="text-danger small">必須</sapn>
                    <p class="text-muted small my-1">50文字以内</p>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id=" name" name="name" required value="{{ old('name') }}" placeholder="献立セレクター">
                    @include('error_input_under', ['name' => 'name'])
                </div>

                <div class="form-group mt-3">
                    <label for="email">メールアドレス</label>
                    <sapn class="text-danger small">必須</sapn>
                    <input type="text" class="form-control mt-1 @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}" placeholder="mail@example.com">
                    @include('error_input_under', ['name' => 'email'])
                </div>

                <div class="form-group mt-3">
                    <label for="password">パスワード</label>
                    <sapn class="text-danger small">必須</sapn>
                    <p class="text-muted small my-1">8文字以上の半角英数</p>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @include('error_input_under', ['name' => 'password'])
                </div>

                <div class="form-group mt-3">
                    <label for="password_confirmation">パスワード(確認)</label>
                    <sapn class="text-danger small">必須</sapn>
                    <input type="password" class="form-control mt-1" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="d-grid my-4">
                    <button type="submit" class="btn btn-success text-white btn-lg">登録する</button>
                </div>
            </form>
            <hr>
            <div class="d-grid my-4">
                <a class="btn btn-lg btn-google text-dark" href="{{ route('login.{provider}', ['provider' => 'google']) }}">
                    <i class="fab fa-google"></i>
                    <sapn>Googleで登録</sapn>
                </a>
            </div>
            <hr>
            <div class="text-center">
                <a class="text-orange" href="{{ route('login') }}">ログインはこちら</a>
            </div>
        </div>
    </div>
</div>
@endsection
