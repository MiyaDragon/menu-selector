@extends('app')

@section('title', '献立登録')

@section('content')
@include('nav')
<div class="container" style="max-width: 540px">
    <h1 class="text-center mt-2">献立セレクター</h1>
    <div class="card mt-3">
        <div class="card-body">

            <h2 class="card-title text-center mt-2">献立登録</h2>

            @include('error_card_list')

            <form method="POST" action="{{ route('menus.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="menu_name">献立名</label>
                    <input type="text" class="form-control" id="menu_name" name="menu_name" required value="{{ old('menu_name') }}">
                </div>

                <div class="form-group">
                    <label for="genre_name">ジャンル名</label>
                    <input type="text" class="form-control" id="genre_name" name="genre_name" required value="{{ old('genre_name') }}">
                </div>

                <div class="form-group">
                    <label for="menu_image">画像</label>
                    <input type="file" class="form-control" id="menu_image" name="menu_image">
                </div>

                <button type="submit" class="btn btn-block btn-primary mt-4">献立登録</button>

            </form>
        </div>
    </div>
</div>
@endsection
