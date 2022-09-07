@extends('app')

@section('title', '献立一覧 - 献立セレクター')

@section('content')
@include('nav')
<div class="container" style="max-width: 1000px;">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 my-3">
        @foreach($menus as $menu)
        <div class="col">
            <div class="card h-100">
                <img src="{{ $menu_image_urls[$menu->id] ?? asset('images/noImage.jpeg')  }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="menu">
                            <label>献立名</label>
                            <p class="h5 fw-bolder d-sm-none">{{ $menu->getLimitName() }}</p>
                            <p class="h5 fw-bolder d-none d-sm-block">{{ $menu->getLimitName(7) }}</p>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('menus.edit', ['menu' => $menu]) }}" class="btn btn-sm btn-success text-white">編集</a>
                            <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $menu->id }}">削除</a>
                        </div>
                    </div>
                    <div class="genre">
                        <label>ジャンル</label>
                        <p class="h5 fw-bolder d-sm-none">{{ $menu->genre->getLimitName() }}</p>
                        <p class="h5 fw-bolder d-none d-sm-block">{{ $menu->genre->getLimitName(12) }}</p>
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
