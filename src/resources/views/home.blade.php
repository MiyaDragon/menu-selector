@extends('app')

@section('title', '献立セレクター')

@section('content')
@include('nav')
<div class="container text-center">
    <div class="card mt-3 mx-auto" style="max-width: 500px">
        <img src="{{ asset('storage/noImage.jpeg') }}" class="card-img-top" alt="食品の画像">
        <div class="card-body">
            <h3 class="card-title pb-2 skyblue">{{ $menu->name ?? '今日の献立は...' }}</h3>
            @auth
            <form method="POST" action="{{ route('show') }}">
                @endauth
                @guest
                <form method="POST" action="{{ route('show') }}">
                    @endguest
                    @csrf
                    <div class="card-text row">
                        <div class="col-2">
                            <label for="genre" class="col-form-label">ジャンル</label>
                        </div>
                        <div class="col-10">
                            <select name="genre_id" class="form-select" id="genre">
                                <option value="all">全てのジャンル</option>
                                @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning mt-4 px-5">決定</button>
                </form>
        </div>
    </div>
</div>
@endsection
