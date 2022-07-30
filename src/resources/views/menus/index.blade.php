@extends('app')

@section('title', '献立一覧')

@section('content')
@include('nav')
<div class="container">
    @foreach($menus as $menu)
    <div class="card mt-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-2">
                <img src="" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <label for="">献立名</label>
                    <h5 class="card-text">{{ $menu->name }}</h5>
                    <label for="">ジャンル</label>
                    <h5 class="card-text">{{ $menu->genre->name }}</h5>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card-body">
                    <a href="{{ route('menus.edit', ['menu' => $menu]) }}" class="btn btn-primary">編集</a>
                    <a href="#" class="btn btn-danger mt-3">削除</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
