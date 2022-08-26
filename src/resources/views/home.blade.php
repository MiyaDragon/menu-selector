@extends('app')

@section('title', '献立セレクター')

@section('content')
@include('nav')
<div class="container text-center">
    <div class="card my-5 mx-auto" style="max-width: 450px">
        <div class="card-body">
            <h3 class=" card-title">今日の献立は...</h3>
            <form method="POST" action="{{ route('show') }}">
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
                <button type="submit" class="btn btn-orange mt-4 px-5">スタート</button>
            </form>
        </div>
    </div>
</div>
@endsection
