@extends('app')

@section('title', 'カレンダー - 献立セレクター')

@section('content')
@include('nav')
<div class="container">
    <div class="my-3 d-flex">
        <a href="?ym={{ $current_dates->copy()->subMonth(1)->format('Y-n') }}" class="btn btn-light d-flex align-items-center justify-content-center">
            <i class="fas fa-caret-left fa-2x"></i>
        </a>
        <h3 class="d-flex align-items-center mb-0">{{ $current_dates->format("Y年m月") }}</h3>
        <a href="?ym={{ $current_dates->copy()->addMonth(1)->format('Y-n') }}" class="btn btn-light d-flex align-items-center justify-content-center">
            <i class="fas fa-caret-right fa-2x"></i>
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
                <th>{{ $dayOfWeek }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($dates as $date)
            @if ($date->dayOfWeek == 0)
            <tr>
                @endif
                <td @if($date->month != $current_dates->format("m")) class="bg-secondary" @endif style="height: 100px; width: 100px;">
                    {{ $date->day }}
                    @foreach ($menus as $menu)
                    @if ($date == $menu->pivot->created_at)
                    @isset($menu->recipe_url)
                    <a href="{{ $menu->recipe_url->url }}" class="d-block text-dark">{{ $menu->name }}</a>
                    @else
                    <p class="text-dark">{{ $menu->name }}</p>
                    @endisset
                    @endif
                    @endforeach
                </td>
                @if ($date->dayOfWeek == 6)
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection
