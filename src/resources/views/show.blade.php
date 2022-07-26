@extends('app')

@section('title', '献立セレクター')

@section('content')
@include('nav')
<div class="container text-center">
    <div class="card my-5 mx-auto shadow-sm" style="max-width: 450px">
        <img src="{{ $menu_image_url ?? asset('images/noImage.jpeg') }}" class="card-img-top" alt="食べ物の画像" style="max-width: 450px; max-height: 330px;">
        <div class="card-body">
            <h3 class=" card-title pb-2 fw-bolder">{{ $menu->name }}</h3>
            @isset($recipe_url)
            <button type="button" class="btn btn-outline-success mb-3" onclick="location.href= '{{ $recipe_url }}'">レシピを見る（外部サイト）</button>
            @endisset
            <form method="POST" action="{{ route('show') }}">
                @csrf
                <div class="card-text row pt-2">
                    <div class="col-3 pe-0">
                        <label class="col-form-label" for="genre">ジャンル</label>
                    </div>
                    <div class="col-9 ps-0">
                        <select class="form-select bg-white" id="genre" name="genre_id">
                            <option value="all">全てのジャンル</option>
                            @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-grid col-6 mx-auto my-4">
                    <button type="submit" class="btn btn-orange text-white fw-bolder px-5">もう一度</button>
                </div>
            </form>
            @auth
            <form method="POST" action="{{ route('menus.ateMenuStore', ['menu' => $menu] ) }}">
                @csrf
                <div class="d-grid col-6 mx-auto mb-4">
                    <button type="submit" class="btn btn-outline-success fw-bolder">今日の献立に決定</button>
                </div>
            </form>
            @endauth
        </div>
    </div>
</div>
@endsection
