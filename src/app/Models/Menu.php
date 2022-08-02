<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'genre_id',
    ];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function menu_image(): BelongsTo
    {
        return $this->belongsTo(MenuImage::class);
    }
}
