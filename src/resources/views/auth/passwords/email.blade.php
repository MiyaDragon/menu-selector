@extends('app')

@section('title', 'パスワード再設定')

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

                <div class="form-group">
                    <label class="fw-bolder mb-2" for="email">メールアドレス</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}" placeholder="mail@example.com">
                    @include('error_input_under', ['name' => 'email'])
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('login') }}" type="button" class="btn btn-outline-dark mx-2">キャンセル</a>
                    <button type="submit" class="btn btn-warning text-white">送信</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
