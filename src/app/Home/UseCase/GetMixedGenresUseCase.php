<?php

namespace App\Home\UseCase;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

final class GetMixedGenresUseCase
{
    /**
     * 登録済みのジャンルと楽天レシピAPIから取得したジャンルを結合
     * @return Collection
     */
    public function get(array $rakuten_genres): Collection
    {
        $genres = Auth::user()->genres;
        foreach ($rakuten_genres as $genre) {
            $genres = $genres->add($genre);
        }

        return $genres;
    }
}
