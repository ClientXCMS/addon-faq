<?php

namespace App\Addons\Faq\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FaqCategory extends Model
{
    use Translatable;

    protected $table = 'faq_categories';

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    protected array $translatableKeys = [
        'name' => 'text',
    ];

    protected $attributes = [
        'order' => 0,
    ];

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class, 'category_id');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public static function withFaqCounts(): Builder
    {
        return static::query()->withCount('faqs');
    }
}