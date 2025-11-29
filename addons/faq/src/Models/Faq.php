<?php

namespace App\Addons\Faq\Models;

use App\Models\Store\Group;
use App\Models\Store\Product;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faq extends Model
{
    use Translatable;

    protected $table = 'faqs';       

    protected $fillable = [
        'title',
        'answer',
        'group_id',
        'product_id',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    protected array $translatableKeys = [
        'title'   => 'text',
        'answer' => 'textarea',
    ];

    protected $attributes = [
        'order' => 0,
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function usefulnessVotes(): HasMany
    {
        return $this->hasMany(FaqUsefulness::class);
    }

    public function scopeWithUsefulnessCounts(Builder $query): Builder
    {
        return $query->withCount([
            'usefulnessVotes as useful_yes_count' => fn (Builder $builder) => $builder->where('is_useful', true),
            'usefulnessVotes as useful_no_count'  => fn (Builder $builder) => $builder->where('is_useful', false),
        ]);
    }

    public static function forContext(?Group $group = null, ?Product $product = null): Collection
    {
        return static::query()
            ->withUsefulnessCounts()
            ->when($group, fn (Builder $query) => $query->where('group_id', $group->id))
            ->when($product, fn (Builder $query) => $query->where('product_id', $product->id))
            ->when(! $group && ! $product, fn (Builder $query) => $query->whereNull('group_id')->whereNull('product_id'))
            ->orderBy('order')
            ->orderBy('id')
            ->get();
    }

    public function getTotalVotesAttribute(): int
    {
        $yes = (int) ($this->attributes['useful_yes_count'] ?? 0);
        $no  = (int) ($this->attributes['useful_no_count'] ?? 0);

        return $yes + $no;
    }

    public function getUsefulRatioAttribute(): ?int
    {
        if ($this->total_votes === 0) {
            return null;
        }

        $yes = (int) ($this->attributes['useful_yes_count'] ?? 0);

        return (int) round(($yes / $this->total_votes) * 100);
    }
}
