<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'title', 'subtitle', 'image', 'button_text', 'action_type',
    'action_product_id', 'action_url', 'is_active', 'sort_order',
])]
class Banner extends Model
{
    /** @use HasFactory<Banner> */
    use HasFactory;

    /**
     * Get the product linked to the banner action.
     */
    public function actionProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'action_product_id');
    }

    /**
     * Scope a query to only include active banners.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
