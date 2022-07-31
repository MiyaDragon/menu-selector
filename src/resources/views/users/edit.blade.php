@extends('app')

@section('title', 'ユーザー情報変更')

@section('content')
@include('nav')
<div class="container" style="max-width: 540px">
    <h1 class="text-center mt-2">献立セレクター</h1>
    <div class="card mt-3">
        <div class="card-body">

            <h2 class="card-title text-center mt-2">ユーザー情報変更</h2>

            @include('error_card_list')

            <form method="POST" action="{{ route('users.update') }}">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label for="name">ユーザー名</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name }}">
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="text" class="form-control" id="email" name="email" required value="{{ $user->email }}">
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">パスワード（確認）</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-block btn-primary mt-4">変更</button>

            </form>
        </div>
    </div>
</div>
@endsection
