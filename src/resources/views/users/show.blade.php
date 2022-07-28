@extends('app')

@section('title', 'マイページ')

@section('content')
@include('nav')
<div class="container" style="max-width: 540px">
    <h1 class="text-center mt-2">献立セレクター</h1>
    <div class="card mt-3">
        <div class="card-body">

            <h2 class="card-title text-center mt-2">マイページ</h2>

            <div class="form-group">
                <a href="{{ route('menus.create') }}" class="btn btn-block btn-primary mt-4">献立登録</a>
                <a href="{{ route('menus.delete') }}" class="btn btn-block btn-primary mt-4">献立削除</a>
                <a href="{{ route('menus.create') }}" class="btn btn-block btn-primary mt-4">登録情報変更</a>
            </div>

        </div>
    </div>
</div>
@endsection
