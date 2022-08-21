@extends('app')

@section('title', 'ユーザー名変更 - 献立セレクター')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 mt-4 text-center fw-bolder">ユーザー名変更</h1>
    <div class="card mt-3 mx-auto">
        <div class="card-body mt-3 mx-4">

            <form method="POST" action="{{ route('users.updateName') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">ユーザー名</label>
                    <p class="text-muted small my-1">50文字以内</p>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ $user->name }}">
                    @include('error_input_under', ['name' => 'name'])
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
