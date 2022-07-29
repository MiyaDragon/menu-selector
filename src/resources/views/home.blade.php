@extends('app')

@section('title', '献立セレクター')

@section('content')
@include('nav')
<div class="container text-center">
    <div class="card mt-3 mx-auto" style="width: 500px;">
        <img src="{{ asset('storage/noImage.jpeg')}}" class="card-img-top" alt="...">
        <div class="card-body">
            <h3 class="card-title">{{ $menu->name ?? '今日の献立は...' }}</h3>
            <form method="POST" action="{{ route('show') }}">
                @csrf
                <div class="card-text row">
                    <div class="col-2">
                        <label for="genre" class="col-form-label">ジャンル</label>
                    </div>
                    <div class="col-10">
                        <select name="genre_id" class="form-control" id="genre">
                            <option style="display: none;" value="all">▽選択してください</option>
                            @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">決定</button>
            </form>
        </div>
    </div>
</div>
@endsection
