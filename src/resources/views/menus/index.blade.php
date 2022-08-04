@extends('app')

@section('title', '献立一覧')

@section('content')
@include('nav')
<div class="container">
    @foreach($menus as $menu)
    <div class="card mt-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-2">
                @if ($menu->menu_image)
                <img src="{{ $menu->menu_image->GetPresignedURL() }}" class="card-img-top" alt="...">
                @else
                <img src="{{ asset('images/noImage.jpeg') }}" class="card-img-top" alt="...">
                @endif
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
                    <a class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $menu->id }}">削除</a>
                </div>
            </div>
            <!-- modal -->
            <div id="modal-delete-{{ $menu->id }}" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('menus.destroy', ['menu' => $menu]) }}">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                {{ $menu->name }}を削除します。よろしいですか？
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                <button type="submit" class="btn btn-danger">削除する</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- modal -->
        </div>
    </div>
    @endforeach
</div>
@endsection
