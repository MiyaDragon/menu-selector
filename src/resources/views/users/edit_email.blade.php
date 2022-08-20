@extends('app')

@section('title', 'メールアドレス変更')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 mt-4 text-center fw-bolder">ユーザー編集</h1>
    <div class="card mt-3 mx-auto">
        <div class="card-body mt-3 mx-4">

            <form method="POST" action="{{ route('users.updateEmail') }}">
                @csrf
                @method('PUT')

                <div class="form-group mt-3">
                    <label for="email">メールアドレス</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required required value="{{ $user->email }}">
                    @include('error_input_under', ['name' => 'email'])
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
