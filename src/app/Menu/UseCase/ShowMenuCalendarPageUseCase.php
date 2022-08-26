<?php

namespace App\Menu\UseCase;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

final class ShowMenuCalendarPageUseCase
{
    /**
     * ページ内に表示される内容
     * ・月毎のカレンダー
     * ・食べた献立を登録していれば、カレンダー日に表示
     * @param ?string $ym
     * @return array
     */
    public function handle(?string $ym): array
    {
        $dt = new Carbon();
        $year = $ym ? mb_substr($ym, 0, 4) : $dt->year;
        $month = $ym ? mb_substr($ym, 5) : $dt->month;

        $current_date = new Carbon("{$year}-{$month}-1");

        $dates = $this->getCalendarDates($year, $month);

        $menus = Auth::user()->ate_menus;

        return [
            'menus' => $menus,
            'dates' => $dates,
            'current_date' => $current_date,
        ];
    }

    /**
     * カレンダーに表示する日数を取得
     * @param int $yeary
     * @param int $month
     * @return array
     */
    private function getCalendarDates(int $year, int $month): array
    {
        $date = new Carbon("{$year}-{$month}-01");

        $addDay = ($date->copy()->endOfMonth()->isSunday() || $date->dayOfWeek == 6) ? 7 : 0;

        $date->subDay($date->dayOfWeek);

        $count = 31 + $addDay + $date->dayOfWeek;
        $count = ceil($count / 7) * 7;

        $dates = [];

        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            $dates[] = $date->copy();
        }

        return $dates;
    }
}
