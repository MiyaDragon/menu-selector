@extends('app')

@section('title', '献立登録')

@section('content')
@include('nav')
<div class="container" style="max-width: 450px">
    <h1 class="h3 mt-4 text-center fw-bolder">献立登録</h1>
    <div class="card mt-3 mx-auto">
        <div class="card-body mt-3 mx-4">
            <form method="POST" action="{{ route('menus.store') }}" enctype="multipart/form-data">

                @include('menus.form', ['btn_name' => '登録する'])

            </form>
        </div>
    </div>
</div>
@endsection
