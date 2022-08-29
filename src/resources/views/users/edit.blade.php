@extends('app')

@section('title', 'アカウント設定 - 献立セレクター')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 mt-4 text-center fw-bolder">アカウント設定</h1>
    <div class="card mt-3 mx-auto">
        <div class="card-body my-4 mx-4">

            <div class="form-group mb-4">
                <label for="name" class="mb-2 me-1 fw-bolder">ユーザーネーム</label>
                <sapn class="small"><a href="{{ route('users.editName') }}" class="text-orange text-decoration-none">変更</a></sapn>
                <p>{{ $user->name }}</p>
            </div>

            <div class="form-group mb-4">
                <label for="name" class="mb-2 me-1 fw-bolder">メールアドレス</label>
                <sapn class="small"><a href="{{ route('users.editEmail') }}" class="text-orange text-decoration-none">変更</a></sapn>
                <p>{{ $user->email }}</p>
            </div>

            <div class="form-group">
                <label for="password" class="mb-2 me-1 fw-bolder">パスワード</label>
                <sapn class="small"><a href="{{ route('users.editPassword') }}" class="text-orange text-decoration-none">変更</a></sapn>
                <p>********</p>
            </div>

            <hr>

            <div class="pt-2">
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
