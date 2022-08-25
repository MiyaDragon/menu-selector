<?php

namespace App\Genre\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Models\Genre;

final class CreateGenreUseCase
{
    /**
     * ・既にジャンルが登録されている場合
     * 送られてきたジャンルをそのまま返す
     *
     * ・まだジャンルが登録されていない場合
     * ジャンルを登録し、登録したジャンルを返す
     *
     * @return Genre
     */
    public function handle(string $genre_name): Genre
    {
        $genre = Auth::user()->genres
            ->where('name', $genre_name)
            ->first();

        if (empty($genre)) {
            $genre = Genre::create([
                'user_id' => Auth::id(),
                'name' => $genre_name,
            ]);
        };

        return $genre;
    }
}
