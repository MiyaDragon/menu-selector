<?php

namespace App\Home\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Lib\RecipeCategories\RecipeCategoriesInterface;

final class ShowHomePageUseCase
{
    private RecipeCategoriesInterface $genres;

    public function __construct(RecipeCategoriesInterface $genres)
    {
        $this->genres = $genres;
    }

    /**
     * ページ内に表示される内容
     * ・ログイン前：楽天レシピAPIから取得したジャンル
     * ・ログイン後：楽天レシピAPIから取得したジャンル＋自分で登録した献立
     * ジャンル
     * @return array
     */
    public function handle(): array
    {
        if (Auth::check()) {
            $genres = (new GetMixedGenresUseCase())->get($this->genres->get());
        } else {
            $genres = $this->genres->get();
        }

        return [
            'genres' => $genres
        ];
    }
}
