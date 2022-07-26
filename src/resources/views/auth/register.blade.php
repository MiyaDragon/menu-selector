@extends('app')

@section('title', 'ユーザー登録')

@section('content')
<div class="container" style="max-width: 540px">
    <h1 class="text-center">献立セレクター</h1>
    <div class="card mt-3">
        <div class="card-body">

            <h2 class="card-title text-center mt-2">ユーザー登録</h2>

            @include('error_card_list')

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">ユーザー名</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="text" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">パスワード（確認）</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>

                </div>

                <button type="submit" class="btn btn-block btn-primary mt-4">ユーザー登録</button>

            </form>
        </div>
    </div>
</div>
@endsection
