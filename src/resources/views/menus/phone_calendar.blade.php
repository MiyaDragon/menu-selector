<div class="d-md-none">
    <table class="table table-bordered bg-white">
        <tbody>
            @foreach ($dates as $date)
            <tr>
                <td @if($date==$today) class="bg-orange" @endif
                    @if($date->month != $current_date->format("m")) class="d-none" @endif
                    @if($date->dayOfWeekIso == 6) class="text-primary" @endif
                    @if($date->dayOfWeekIso == 7) class="text-danger" @endif
                    id="calendar">
                    {{ $date->day }}
                    {{ $date->isoFormat('(ddd)') }}
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
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
