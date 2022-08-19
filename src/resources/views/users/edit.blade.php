@extends('app')

@section('title', 'ユーザー情報変更')

@section('content')
@include('nav')
<div class="container" style="max-width: 500px">
    <h1 class="h3 mt-4 text-center fw-bolder">ユーザー編集</h1>
    <div class="card mt-3 mx-auto">
        <div class="card-body mt-3 mx-4">

            <form method="POST" action="{{ route('users.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">ユーザーネーム</label>
                    <p class="text-muted small my-1">50文字以内</p>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id=" name" name="name" required value="{{ $user->name }}">
                    @include('error_input_under', ['name' => 'name'])
                </div>

                <div class="form-group mt-3">
                    <label for="email">メールアドレス</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required required value="{{ $user->email }}">
                    @include('error_input_under', ['name' => 'email'])
                </div>

                <div class="form-group mt-3">
                    <label for="password">パスワード</label>
                    <p class="text-muted small my-1">8文字以上の半角英数</p>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @include('error_input_under', ['name' => 'password'])
                </div>

                <div class="form-group mt-3">
                    <label for="password_confirmation">パスワード(確認)</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="d-grid gap-2 my-4">
                    <button type="submit" class="btn btn-orange text-white btn-lg">変更する</button>
                </div>
            </form>

            <hr>

            <div class="mt-2">
                <a class="text-dark" type="button" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $user->id }}">退会する</a>
            </div>

            <!-- modal -->
            <div id="modal-delete-{{ $user->id }}" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bolder">本当に退会しますか？</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('users.destroy', ['user' => $user]) }}">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                一度退会するとデータは全て削除され復旧できません。
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                <button type="submit" class="btn btn-danger">退会する</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- modal -->

        </div>

    </div>
</div>
@endsection
