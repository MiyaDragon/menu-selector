@extends('app')

@section('title', 'パスワード再設定 - 献立セレクター')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 my-4 text-center fw-bolder">パスワード再設定</h1>
    <div class="card mx-auto">
        <div class="card-body mx-4 my-3">

            @if (session('status'))
            <div class="card-text alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group mb-4">
                    <label class="fw-bolder mb-1" for="email">メールアドレス</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}" placeholder="mail@example.com">
                    @include('error_input_under', ['name' => 'email'])
                </div>

                <div class="d-grid gap-2 mb-2">
                    <button type="submit" class="btn btn-orange text-white">送信</button>
                    <a type="button" onClick="history.back()" class="btn btn-outline-dark">戻る</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
