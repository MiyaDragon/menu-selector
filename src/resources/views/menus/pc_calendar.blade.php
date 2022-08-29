<div class="d-none d-md-block">
    <table class="table table-bordered bg-white">
        <thead>
            <tr class="normal-calendar">
                @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
                <th>{{ $dayOfWeek }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($dates as $date)
            @if ($date->dayOfWeek == 0)
            <tr class="normal-calendar">
                @endif
                <td @if($date->month != $current_date->format("m")) class="bg-secondary" @endif id="calendar">
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
