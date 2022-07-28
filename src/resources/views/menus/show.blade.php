@extends('app')

@section('title', '献立一覧')

@section('content')
@include('nav')
<div class="container" style="max-width: 540px">
    <h1 class="text-center mt-2">献立セレクター</h1>
    <div class="card mt-3">
        <div class="card-body">

            <h2 class="card-title text-center mt-2">献立削除</h2>

            @include('error_card_list')

            <form method="POST" action="{{ route('menus.destroy') }}">
                @csrf
                <div class="form-group">
                    <label for="name">献立名</label>
                    <select class="form-control" name="menu_id">
                        <option style="display: none;">選択してください</option>
                        @foreach($menus as $menu)
                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="genre">ジャンル名</label>
                    <select class="form-control" name="genre_id">
                        <option style="display: none;">選択してください</option>
                        @foreach($menus as $menu)
                        <option value="{{ $menu->genre_id }}">{{ $menu->genre->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-block btn-primary mt-4">献立削除</button>

            </form>
        </div>
    </div>
</div>

@endsection
