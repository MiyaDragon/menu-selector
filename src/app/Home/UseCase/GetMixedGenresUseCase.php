<?php

namespace App\Home\UseCase;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

final class GetMixedGenresUseCase
{
    /**
     * 登録済みのジャンルと楽天レシピAPIから取得したジャンルを結合
     * @param Collection $rakuten_genres
     * @return Collection
     */
    public function get(Collection $rakuten_genres): Collection
    {
        $genres = $rakuten_genres->merge(Auth::user()->genres);

        return $genres;
    }
}
