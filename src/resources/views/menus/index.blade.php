@extends('app')

@section('title', '献立一覧')

@section('content')
@include('nav')
<div class="container" style="max-width: 1000px;">
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
        @foreach($menus as $menu)
        <div class="col">
            <div class="card h-100">
                @if ($menu->menu_image)
                <img src="{{ $menu->menu_image->GetPresignedURL() }}" class="card-img-top" alt="...">
                @else
                <img src="{{ asset('images/noImage.jpeg') }}" class="card-img-top" alt="...">
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="menu">
                            <label>献立名</label>
                            <h4>{{ $menu->name }}</h4>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('menus.edit', ['menu' => $menu]) }}" class="btn btn-sm btn-outline-orange bg-white text-dark">編集</a>
                            <a class="btn btn-sm btn-orange text-white" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $menu->id }}">削除</a>
                        </div>
                    </div>
                    <div class="genre">
                        <label>ジャンル</label>
                        <h4>{{ $menu->genre->name }}</h4>
                    </div>
                </div>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                            <button type="submit" class="btn btn-danger">削除する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal -->
        @endforeach
    </div>
    {{ $menus->links('vendor.pagination.menus-pagination') }}
</div>
@endsection
