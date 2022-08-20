@extends('app')

@section('title', 'パスワード変更')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 mt-4 text-center fw-bolder">ユーザー編集</h1>
    <div class="card mt-3 mx-auto">
        <div class="card-body mt-3 mx-4">

            <form method="POST" action="{{ route('users.updatePassword') }}">
                @csrf
                @method('PUT')

                <div class="form-group mt-3">
                    <label for="password">現在のパスワード</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @include('error_input_under', ['name' => 'password'])
                </div>
                <div class="my-2">
                    <a class="text-dark small" href="{{ route('password.request') }}">パスワードを忘れた方</a>
                </div>

                <div class="form-group mt-3">
                    <label for="new_password">新しいパスワード</label>
                    <p class="text-muted small my-1">8文字以上の半角英数</p>
                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
                    @include('error_input_under', ['name' => 'new_password'])
                </div>

                <div class="form-group mt-3">
                    <label for="new_password_confirmation">新しいパスワード(確認)</label>
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>

                <div class="d-grid gap-2 my-4">
                    <button type="submit" class="btn btn-orange text-white btn-lg">変更する</button>
                </div>
                <div class="d-grid gap-2 my-4">
                    <button type="button" onClick="history.back()" class="btn btn-outline-orange btn-lg">戻る</button>
                </div>
            </form>

        </div>

    </div>
</div>
@endsection
