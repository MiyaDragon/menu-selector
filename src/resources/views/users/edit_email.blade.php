@extends('app')

@section('title', 'メールアドレス変更 - 献立セレクター')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 my-4 text-center fw-bolder">メールアドレス変更</h1>
    <div class="card mx-auto">
        <div class="card-body my-3 mx-4">

            <form method="POST" action="{{ route('users.updateEmailLink') }}">
                @csrf

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="text" class="form-control mt-1 @error('email') is-invalid @enderror" id="email" name="email" required>
                    @include('error_input_under', ['name' => 'email'])
                </div>

                <div class="d-flex flex-row-reverse justify-content-start mt-4">
                    <button type="submit" class="btn btn-success text-white">変更する</button>
                    <a type="button" onClick="history.back()" class="btn btn-google text-dark me-3">キャンセル</a>
                </div>
            </form>

        </div>

    </div>
</div>
@endsection
