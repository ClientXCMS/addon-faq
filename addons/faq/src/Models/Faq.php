<?php

namespace App\Addons\Faq\Models;

use App\Models\Store\Group;
use App\Models\Store\Product;
use App\Models\Traits\HasMetadata;
use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faq extends Model
{
    use HasMetadata;
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
        $yes = (int) ($this->useful_yes_count ?? 0);
        $no  = (int) ($this->useful_no_count ?? 0);

        return $yes + $no;
    }

    public function getUsefulRatioAttribute(): ?int
    {
        if ($this->total_votes === 0) {
            return null;
        }

        $yes = (int) ($this->useful_yes_count ?? 0);

        return (int) round(($yes / $this->total_votes) * 100);
    }

    public static function forSection(string $section, ?int $limit = null): Collection
    {
        $query = static::query()
            ->with(['group', 'product', 'metadata'])
            ->withUsefulnessCounts()
            ->whereHas('metadata', function ($q) use ($section) {
                $q->where('key', 'display_' . $section)
                  ->where('value', '1');
            })
            ->orderBy('order')
            ->orderBy('id');

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public static function getAvailableSections(): array
    {
        if (!app()->bound('faq.sections')) {
            return [];
        }

        return app('faq.sections')->all();
    }

    public function shouldDisplayOn(string $section): bool
    {
        return $this->getMetadata('display_' . $section) === '1';
    }

    public function setDisplaySections(array $sections): void
    {
        foreach (static::getAvailableSections() as $key => $label) {
            if (in_array($key, $sections)) {
                $this->attachMetadata('display_' . $key, '1');
            } else {
                $this->detachMetadata('display_' . $key);
            }
        }
    }
}
