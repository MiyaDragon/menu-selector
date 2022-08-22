@extends('app')

@section('title', '献立セレクター')

@section('content')
@include('nav')
<div class="container text-center">
    <div class="card my-5 mx-auto" style="max-width: 450px">
        @isset($menu_image_url)
        <img src="{{ $menu_image_url ?? asset('images/noImage.jpeg') }}" class="card-img-top" alt="食べ物の画像" style="max-width: 450px; max-height: 330px;">
        @else
        <img src="{{ asset('images/noImage.jpeg') }}" class="card-img-top" alt="食べ物の画像">
        @endisset
        <div class="card-body">
            @isset($menu)
            <h3 class=" card-title pb-2 fw-bolder">{{ $menu->name }}</h3>
            @else
            <h3 class=" card-title">今日の献立は...</h3>
            @endisset
            @isset($recipe_url)
            <button type="button" class="btn btn-outline-orange mb-3" onclick="location.href= '{{ $recipe_url }}'">レシピを見る（外部サイト）</button>
            @endisset
            <form method="POST" action="{{ route('show', ['menu' => $menu ?? null]) }}">
                @csrf

                <div class="card-text row pt-2">
                    <div class="col-3">
                        <label for="genre" class="col-form-label">ジャンル</label>
                    </div>
                    <div class="col-9">
                        <select name="genre_id" class="form-select" id="genre">
                            <option value="all">全てのジャンル</option>
                            @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @guest
                <button type="submit" class="btn btn-orange mt-4 px-5">スタート</button>
                @endguest

                @auth
                @isset($menu)
                <div class="d-grid gap-3 col-6 mx-auto my-2">
                    <button type="submit" class="btn btn-orange text-white mt-4" name="create">決定</button>
                    <button type="submit" class="btn btn-outline-orange bg-white link-orange">もう一度</button>
                </div>
                @else
                <button type="submit" class="btn btn-orange text-white mt-4 px-5">スタート</button>
                @endisset
                @endauth
            </form>
        </div>
    </div>
</div>
@endsection
