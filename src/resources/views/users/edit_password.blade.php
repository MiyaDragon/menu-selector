@extends('app')

@section('title', 'パスワード変更 - 献立セレクター')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 my-4 text-center fw-bolder">パスワード変更</h1>
    <div class="card mx-auto">
        <div class="card-body my-3 mx-4">

            <form method="POST" action="{{ route('users.updatePassword') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="password">現在のパスワード</label>
                    <input type="password" class="form-control mt-1 @error('password') is-invalid @enderror" id="password" name="password" required>
                    @include('error_input_under', ['name' => 'password'])
                </div>
                <div class="mt-1">
                    <a class="text-dark small" href="{{ route('password.request') }}">パスワードを忘れた方</a>
                </div>

                <div class="form-group mt-4">
                    <label for="new_password">新しいパスワード</label>
                    <p class="text-muted small my-1">8文字以上の半角英数</p>
                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
                    @include('error_input_under', ['name' => 'new_password'])
                </div>

                <div class="form-group mt-4">
                    <label for="new_password_confirmation">新しいパスワード(確認)</label>
                    <input type="password" class="form-control mt-1" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>

                <div class="d-grid gap-4 mt-4">
                    <button type="submit" class="btn btn-success text-white btn-lg">変更する</button>
                    <button type="button" onClick="history.back()" class="btn btn-google btn-lg text-dark">戻る</button>
                </div>
            </form>

        </div>

    </div>
</div>
@endsection
