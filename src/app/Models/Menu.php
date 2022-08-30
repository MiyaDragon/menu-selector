<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'genre_id',
        'menu_image_id',
        'recipe_url_id',
        'name',
    ];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function menu_image(): BelongsTo
    {
        return $this->belongsTo(MenuImage::class);
    }

    public function recipe_url(): BelongsTo
    {
        return $this->belongsTo(RecipeUrl::class);
    }

    public function ate_menus(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ate_menus')->withTimestamps();
    }

    /**
     *  表示文字数制限をした献立名を取得
     *
     * @param int $limit
     * @return string
     */
    public function getLimitName(int $limit = 16): string
    {
        $name = $this->name;

        if (mb_strlen($name) > $limit) {
            $name = mb_substr($name, 0, $limit);
            return $name . "...";
        } else {
            return $name;
        }
    }
}
