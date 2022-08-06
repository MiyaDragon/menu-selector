@extends('app')

@section('title', '献立登録')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 mt-4 text-center fw-bolder">献立編集</h1>
    <div class="card mt-3 mx-auto">
        <div class="card-body mt-3 mx-4">

            @if ($menu->menu_image)
            <img src="{{ $menu->menu_image->GetPresignedURL() }}" class="card-img-top rounded" alt="...">
            @else
            <img src="{{ asset('images/noImage.jpeg') }}" class="card-img-top rounded" alt="...">
            @endif

            <form method="POST" action="{{ route('menus.update', ['menu' => $menu] ) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="form-group mt-3">
                    <label for="menu_name">献立名</label>
                    <span class="text-danger small">必須</span>
                    <input type="text" class="form-control @error('menu_name') is-invalid @enderror" id="menu_name" name="menu_name" required value="{{ $menu->name }}">
                    @include('error_input_under', ['name' => 'menu_name'])
                </div>

                <div class="form-group mt-3">
                    <label for="genre_name">ジャンル名</label>
                    <span class="text-danger small">必須</span>
                    <input type="text" class="form-control @error('genre_name') is-invalid @enderror" id="genre_name" name="genre_name" required value="{{ $menu->genre->name }}">
                    @include('error_input_under', ['name' => 'genre_name'])
                </div>

                <div class="form-group mt-3">
                    <label for="menu_image">画像</label>
                    <span class="text-dark small">(変更の場合のみ)</span>
                    <p class="text-muted small my-1">※画像は .jpg .png に対応しています。</p>
                    <input type="file" accept="image/jpeg, image/png" class="form-control @error('menu_image') is-invalid @enderror" id="menu_image" name="menu_image">
                    @include('error_input_under', ['name' => 'menu_image'])
                </div>

                <div class="d-grid gap-2 my-4">
                    <button type="submit" class="btn btn-warning text-white btn-lg">更新する</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
