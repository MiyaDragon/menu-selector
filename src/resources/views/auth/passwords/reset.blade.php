@extends('app')

@section('title', 'パスワード再設定')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 my-4 text-center fw-bolder">新しいパスワードを設定</h1>
    <div class="card mx-auto">
        <div class="card-body mx-4 my-3">

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label class="fw-bolder mb-2" for="password">新しいパスワード</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @include('error_input_under', ['name' => 'password'])
                </div>

                <div class="form-group mt-4">
                    <label class="fw-bolder mb-2" for="password_confirmation">新しいパスワードの再入力</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-orange text-white">送信</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
