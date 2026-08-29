<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'stock',
        'status',
        'is_favorite',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
