@extends('app')

@section('title', 'カレンダー - 献立セレクター')

@section('content')
@include('nav')
<div class="container">
    <div class="my-4 d-flex">
        <a href="?ym={{ $current_date->copy()->subMonth(1)->format('Y-n') }}" class="d-flex align-items-center justify-content-center text-dark text-decoration-none">
            <i class="fas fa-caret-left fa-2x"></i>
        </a>
        <h3 class="d-flex align-items-center mb-1 mx-3">{{ $current_date->format("Y年m月") }}</h3>
        <a href="?ym={{ $current_date->copy()->addMonth(1)->format('Y-n') }}" class="d-flex align-items-center justify-content-center text-dark text-decoration-none">
            <i class="fas fa-caret-right fa-2x"></i>
        </a>
    </div>

    @include('menus.pc_calendar')
    @include('menus.phone_calendar')

</div>
@endsection
