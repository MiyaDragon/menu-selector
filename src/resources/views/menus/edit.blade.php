@extends('app')

@section('title', '献立編集 - 献立セレクター')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 mt-4 text-center fw-bolder">献立編集</h1>
    <div class="card mt-3 mb-5 mx-auto">
        <div class="card-body my-4 mx-4">
            <img src="{{ $menu_image_url ?? asset('images/noImage.jpeg') }}" class="card-img-top rounded mb-3" alt="...">
            <form method="POST" action="{{ route('menus.update', ['menu' => $menu] ) }}" enctype="multipart/form-data">
                @method('PUT')

                @include('menus.form', ['btn_name' => '更新する'])

            </form>
        </div>
    </div>
</div>
@endsection
