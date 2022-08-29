@extends('app')

@section('title', '献立セレクター')

@section('content')
@include('nav')
<div class="container text-center">
    <div class="card mt-5 mx-auto py-3 shadow-sm" style="max-width: 450px">
        <div class="card-body">
            <h3 class=" card-title">今日の献立は...</h3>
            <form method="POST" action="{{ route('show') }}">
                @csrf
                <div class="card-text row py-3">
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
                <div class="d-grid col-6 mx-auto mt-3">
                    <button type="submit" class="btn btn-orange text-white fw-bolder px-5">スタート</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
