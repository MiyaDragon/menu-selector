@extends('app')

@section('title', 'ユーザー登録 - 献立セレクター')

@section('content')
@include('nav')
<div class="container" style="max-width: 500px">
    <h1 class="h3 mt-4 text-center fw-bolder">ユーザー登録</h1>
    <div class="card mt-3 mx-auto">
        <div class="card-body mt-3 mx-4">

            <form method="POST" action="{{ route('register.{provider}', ['provider' => $provider]) }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="name">ユーザーネーム</label>
                    <sapn class="text-danger small">必須</sapn>
                    <p class="text-muted small my-1">50文字以内</p>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id=" name" name="name" required placeholder="献立セレクター">
                    @include('error_input_under', ['name' => 'name'])
                </div>

                <div class="form-group mt-3">
                    <label for="email">メールアドレス</label>
                    <sapn class="text-danger small">必須</sapn>
                    <input type="text" class="form-control" id="email" name="email" required value="{{ $email }}" disabled>
                </div>

                <div class="d-grid gap-2 my-4">
                    <button type="submit" class="btn btn-warning text-white btn-lg">登録する</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
