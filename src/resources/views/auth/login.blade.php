@extends('app')

@section('title', 'ログイン')

@section('content')
<div class="container" style="max-width: 540px">
    <h1 class="text-center">献立セレクター</h1>
    <div class="card mt-3">
        <div class="card-body">

            <h2 class="card-title text-center mt-2">ログイン</h2>

            @include('error_card_list')

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="text" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <input type="hidden" id="remember" name="remember" value="on">

                <button type="submit" class="btn btn-block btn-primary mt-4">ログイン</button>

            </form>
        </div>
    </div>
</div>
@endsection
